<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL
 * @filesource
 */

/**
 * Class ContaoMapLayerMetaModel - add markers from a metamodel to a map.
 *
 * @copyright  Cyberspectrum 2009
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    Controller
 */
class ContaoMapLayerMetaModel extends ContaoMapLayer
{
	/**
	 * The list to be used for rendering.
	 *
	 * @var MetaModelListContaoMaps
	 */
	protected $objRenderList = NULL;

	protected function getRenderList()
	{
		$this->objRenderList = new MetaModelListContaoMaps();
		return $this->objRenderList;
	}

	protected function prepareRenderList($omitIds)
	{
		$this->objRenderList
			->setAreaAndOmitFilter((!$this->ignore_area_filter ? $this->getAreaFilter('latitude', 'longitude') : ''), $omitIds)
			->setPositionAttribute($this->metamodel_att)
			->setFallbackIcon(sprintf('%s/%s_marker.png', $GLOBALS['TL_CONFIG']['uploadPath'], $this->alias))
			->setMetaModel($this->metamodel, $this->metamodel_rendersettings)
			->setLimit($this->metamodel_use_limit, $this->metamodel_offset, $this->metamodel_limit)
			->setPageBreak($this->perPage)
			->setSorting($this->metamodel_sortby, $this->metamodel_sortby_direction)
			->setFilterParam($this->metamodel_filtering, deserialize($this->metamodel_filterparams, true), $_GET);
	}

	public function assembleObjects($omitObjects)
	{
		$omitIds = array();

		if ($omitObjects['marker'])
		{
			$omitIds = filter_var_array($omitObjects['marker'], FILTER_SANITIZE_NUMBER_INT);
		}

		$objRenderList = $this->getRenderList();

		$this->prepareRenderList($omitIds);

		$arrRendered = $objRenderList->renderMarkers($this->metamodel_noparsing, $this);

		$objPoints = $objRenderList->getItems();

		$objView = $objRenderList->getView();
		$objMetaModel = $objRenderList->getMetaModel();


		$arrIconSize = deserialize($objLayer->imageSize);

		foreach ($arrRendered as $objPoint)
		{
			$this->add($objPoint);
		}
	}
}

?>