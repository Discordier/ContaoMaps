<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage Frontend
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  CyberSpectrum
 * @license    private
 * @filesource
 */


/**
 * Implementation of a general purpose MetaModel listing.
 *
 * @package	   MetaModels
 * @subpackage Frontend
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class MetaModelListContaoMaps extends MetaModels\ItemList
{
	/**
	 * Ignore area filter for ajax requests.
	 *
	 * @var string
	 */
	protected $strAreaFilter = false;

	/**
	 * Ignore ids for ajax requests.
	 *
	 * @var array
	 */
	protected $arrOmitIds = array();

	/**
	 * Id of the attribute to use for positioning.
	 *
	 * @var int
	 */
	protected $intAttrId = 0;

	/**
	 * The fallback marker image to use.
	 *
	 * @var string
	 */
	protected $strFallbackIcon = '';

	/**
	 * Enable or disable the area filtering
	 *
	 * @param string the area filter to use.
	 *
	 * @return MetaModelList
	 */
	public function setAreaAndOmitFilter($strValue, $arrOmitIds)
	{
		$this->strAreaFilter = $strValue;
		$this->arrOmitIds = $arrOmitIds;

		return $this;
	}

	/**
	 * Set the attribute we shall use for positioning
	 *
	 * @param int $intId id of the attribute to use.
	 *
	 * @return MetaModelList
	 */
	public function setPositionAttribute($intId)
	{
		$this->intAttrId = $intId;

		return $this;
	}

	/**
	 * Set fallback icon.
	 *
	 * @param int $strFilename the file to be used as marker image, when none has been defined.
	 *
	 * @return MetaModelList
	 */
	public function setFallbackIcon($strFilename)
	{
		$this->strFallbackIcon = '';
		if(file_exists(TL_ROOT . '/' . $strFilename))
		{
			$this->strFallbackIcon = $strFilename;
		}
		return $this;
	}

	/**
	 * Add additional filter rules to the list.
	 * Can be overridden by subclasses to add additional filter rules to the filter before it will get evaluated.
	 *
	 * @return MetaModelList
	 */
	protected function modifyFilter()
	{
		if ($this->arrOmitIds)
		{
			// add filter rule for omitting already known objects to filter.
			$this->objFilter->addFilterRule(new \MetaModels\Filter\Rules\SimpleQuery(
				sprintf('SELECT * FROM tl_metamodel_geolocation WHERE att_id=? AND item_id NOT IN (%s)', implode(',', $this->arrOmitIds)),
				array($this->intAttrId),
				'item_id')
			);
		}
		if ($this->strAreaFilter)
		{
			// add area filter rule to filter.
			$this->objFilter->addFilterRule(new \MetaModels\Filter\Rules\SimpleQuery(
				'SELECT * FROM tl_metamodel_geolocation WHERE att_id=? AND ' . $this->strAreaFilter,
				array($this->intAttrId),
				'item_id')
			);
		}
		return $this;
	}

	/**
	 * Return all attributes that shall be fetched from the MetaModel.
	 * In addition to the attributes returned by the parent method, the attribute
	 * for positioning is also returned.
	 *
	 * @return string[] the names of the attributes to be fetched.
	 */
	protected function getAttributeNames()
	{
		$objAttr = $this->getMetaModel()->getAttributeById($this->intAttrId);
		if (!$objAttr)
		{
			throw new Exception(sprintf('No geo location attribute found for id %d. Check configuration', $this->intAttrId));
		}
		return array_merge(parent::getAttributeNames(), array($objAttr->getColName()));
	}

	protected function calculateMarkerImage($objItem, $objMarker)
	{

		$strFallbackIcon = '';
		if(file_exists(TL_ROOT . '/'.$GLOBALS['TL_CONFIG']['uploadPath'].'/catalogmarker/' . $objMetaModel->getTableName() . '.png'))
		{
			$strFallbackIcon = $GLOBALS['TL_CONFIG']['uploadPath'] . '/catalogmarker/' . $objMetaModel->getTableName() . '.png';
		}

		// FIXME: this is not implemented yet.
		if($objLayer->catalog_iconfield && $item[$objLayer->catalog_iconfield])
		{
			// TODO: ensure that only one image is in the field, no image gallery
			$objMarker->icon = $this->getImage($this->urlEncode($item[$objLayer->catalog_iconfield]), $iconsize[0], $iconsize[1], $iconsize[2]);
		} elseif($icon)
		{
			$objMarker->icon = $icon;
		}

		if($objMarker->icon)
		{
			$objIcon = new File($pointdata['icon']);
			$objMarker->iconsize = $objIcon->width.','.$objIcon->height;
			$objMarker->iconposition = sprintf('%s,%s', floor($objIcon->width/2), floor($objIcon->height/2));
		}
	}

	/**
	 * Render the list view.
	 *
	 * @param bool $blnNoNativeParsing flag determining if the parsing shall be done internal or if the template will handle the parsing on it's own.
	 *
	 * @param object $objCaller        the object calling us, might be a Module or ContentElement or anything else.
	 *
	 * @return array
	 */
	public function renderMarkers($blnNoNativeParsing, $objCaller)
	{
		$strClass=$GLOBALS['CONTAOMAP_MAPOBJECTS']['marker'];
		if(!$strClass)
			return;

		$this->objTemplate->noItemsMsg = $GLOBALS['TL_LANG']['MSC']['noItemsMsg'];

		$this->prepare();

		$arrMarkers = array();

		$objAttr = $this->objMetaModel->getAttributeById($this->intAttrId);

		if (!$objAttr)
		{
			throw new Exception(sprintf('Error: positioning attribute with id %d not found.', $this->intAttrId), 1);
		}
		$strLocationAttr = $objAttr->getColName();

		//check for icon
		$objIcon = null;
		if ($objCaller->metamodel_icon != null)
		{
			$objIcon=\FilesModel::findByUuid($objCaller->metamodel_icon);
		}

		foreach ($this->objItems as $objItem)
		{
			$this->objTemplate->data = ($this->objItems->getCount() && !$blnNoNativeParsing) ? array($objItem->parseValue($this->strOutputFormat, $this->objView)) : array();
            $this->objTemplate->items = $this->objItems;

			$objMarker = new $strClass(array(
				'jsid' => 'marker_'.$objItem->get('id'),
				'infotext' => $this->objTemplate->parse($this->objView->get('format')),
				'icon' => ($objIcon != null)? $objIcon->path : ''
			));

			$arrPosition = $objItem->get($strLocationAttr);
			$objMarker->latitude = $arrPosition['latitude'];
			$objMarker->longitude = $arrPosition['longitude'];

			$arrMarkers[] = $objMarker;
		}
		return $arrMarkers;
	}
}
