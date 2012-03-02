<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL 
 * @filesource
 */

// internal class for rendering only - not a real module but mimics one to some extend.
class ModuleCatalogWrapperContaoMap extends ModuleCatalogList
{
	protected $strTemplate='contaomap_catalog';

	protected $items;
	protected $omitMarkers;

	public function __construct($objLayer, $omitMarkers, $objMapper)
	{
		parent::__construct($objLayer);
		$this->catalog_visible = deserialize($this->catalog_visible);
		$this->omitMarkers=$omitMarkers;
		$this->mapper = $objMapper;
	}

	public function generate($latLngFilter='')
	{
		$this->latLngFilter=$latLngFilter;
		parent::generate();
		return $this->items;
	}

	protected function compile()
	{
		$cols=array();
		$cols = $this->processFieldSQL($this->catalog_visible);
		if($this->catalog_iconfield)
			$cols[] = $this->catalog_iconfield;
		foreach($this->systemColumns as $col)
			$cols[]=$col;
		if($this->strAliasField)
			$cols[] = $this->strAliasField;

		$omitSQL = $this->omitMarkers?'AND c.id NOT IN ('.implode(', ', $this->omitMarkers).') ':'';
		if($this->catalog_where)
			$omitSQL .= ' AND '.$this->replaceInsertTags($this->catalog_where);
		if(!BE_USER_LOGGED_IN && $this->publishField)
		{
			$omitSQL .= ' AND '.$this->publishField.'=1';
		}
		// add filters from URL.
		$filterurl = $this->parseFilterUrl();
		if (is_array($this->catalog_search) && strlen($this->catalog_search[0]) && is_array($filterurl['procedure']['search']))
		{
			// reset arrays
			$searchProcedure = array();
			$searchValues = array();

			foreach($this->catalog_search as $field)
			{
				if (array_key_exists($field, $filterurl['procedure']['search']))
				{
					$searchProcedure[] = $filterurl['procedure']['search'][$field];
					if (is_array($filterurl['values']['search'][$field]))
					{
						foreach($filterurl['values']['search'][$field] as $item)
						{
							$searchValues[] = $item;
						}
					}
					else
					{
						$searchValues[] = $filterurl['values']['search'][$field];
					}
				}
			}

			$filterurl['procedure']['where'][] = ' ('.implode(" OR ", $searchProcedure).')';
			$filterurl['values']['where'] = is_array($filterurl['values']['where']) ? (array_merge($filterurl['values']['where'],$searchValues)) : $searchValues;

		}

		$params[0] = $this->catalog;
		if (is_array($filterurl['values']['where'])) {
			$params = array_merge($params, $filterurl['values']['where']);
		}

// add tags combination here...

		if (is_array($filterurl['values']['tags'])) {
			$params = array_merge($params, $filterurl['values']['tags']);
		}

		$this->catalog_query_mode = 'AND';
		$this->catalog_tags_mode = 'AND';

		$strCondition = $this->replaceInsertTags($this->catalog_where);
		$strWhere = 
			($filterurl['procedure']['where'] ? " AND ".implode(" ".$this->catalog_query_mode." ", $filterurl['procedure']['where']) : "")
			// TODO: changing the catalog_tags_mode to catalog_query_mode here will allow us to filter multiple tags.
			// 		 but this beares side kicks in ModuleCatalog aswell. Therefore we might rather want to add another combination method
			//		 here?
			.($filterurl['procedure']['tags'] ? " AND ".implode(" ".$this->catalog_tags_mode." ", $filterurl['procedure']['tags']) : "");


		// end add filters from URL.
		$objCatalogStmt = $this->Database->prepare('SELECT c.'.implode(', c.',$cols).", gl.longitude, gl.latitude, (SELECT name FROM tl_catalog_types WHERE tl_catalog_types.id=c.pid) AS catalog_name, (SELECT jumpTo FROM tl_catalog_types WHERE tl_catalog_types.id=c.pid) AS parentJumpTo FROM ".$this->strTable." c RIGHT JOIN tl_catalog_geolocation gl ON (gl.cat_id=c.pid AND gl.item_id=c.id) WHERE c.pid=? ".($omitSQL.$strWhere.$this->latLngFilter));
		$objCatalog = $objCatalogStmt->execute($params);
//		echo '/*'.$objCatalog->query.'*/';
		$items=$this->generateCatalog($objCatalog, true, $this->catalog_visible);
		$objCatalog->reset();
		$i=0;
		while($objCatalog->next())
		{
			if($this->catalog_iconfield)
				$items[$i][$this->catalog_iconfield]=$objCatalog->{$this->catalog_iconfield};
			$items[$i]['longitude']=$objCatalog->longitude;
			$items[$i++]['latitude']=$objCatalog->latitude;
		}
		$this->items=$items;
	}
}

/**
 * Class ContaoMapLayerCatalog - add markers from a catalog to a map.
 *
 * @copyright  Cyberspectrum 2009
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    Controller
 */
class ContaoMapLayerCatalog extends ContaoMapLayer
{
	public function assembleObjects($omitObjects)
	{
		$strClass=$GLOBALS['CONTAOMAP_MAPOBJECTS']['marker'];
		if(!$strClass)
			return;
		$objLayer = $this->Database->prepare('SELECT * FROM tl_contaomap_layer WHERE id=?')->execute($this->id);
		$omitIds=($omitObjects['marker'])?filter_var_array($omitObjects['marker'], FILTER_SANITIZE_NUMBER_INT):array();

		$renderer = new ModuleCatalogWrapperContaoMap($objLayer, $omitIds, $this);
		$area = ($objLayer->ignore_area_filter? '': $this->getAreaFilter('gl.latitude', 'gl.longitude'));
		$items=$renderer->generate($area?' AND '.$area:'');

		// TODO: we have to find a better way to select icon images than this.
		// Definately!
		// Backend config would be nice, but which one? Reader? Fieldconfig? Catalog itself?
		$item=$items[0];
		if(file_exists(TL_ROOT . '/'.$GLOBALS['TL_CONFIG']['uploadPath'].'/catalogmarker/'.$item['tablename'].'.png'))
		{
			$icon = $GLOBALS['TL_CONFIG']['uploadPath'].'/catalogmarker/'.$item['tablename'].'.png';
		}
		$iconsize = deserialize($objLayer->imageSize);
		foreach($items as $i=>$item)
		{
			$tpl = new FrontendTemplate($objLayer->catalog_template);
			$tpl->entries=array($item);
			$objMarker = new $strClass(array(
				'jsid' => 'marker_'.$item['id'],
				'infotext' => $tpl->parse()
			));
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
			$objMarker->latitude = $item['latitude'];
			$objMarker->longitude = $item['longitude'];

			$this->add($objMarker);
		}
	}
}

?>