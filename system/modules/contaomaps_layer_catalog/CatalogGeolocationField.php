<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL 
 * @filesource
 */



/*
select *,
	acos(cos(centerLat * (PI()/180)) *
	 cos(centerLon * (PI()/180)) *
	 cos(lat * (PI()/180)) *
	 cos(lon * (PI()/180))
	 +
	 cos(centerLat * (PI()/180)) *
	 sin(centerLon * (PI()/180)) *
	 cos(lat * (PI()/180)) *
	 sin(lon * (PI()/180))
	 +
	 sin(centerLat * (PI()/180)) *
	 sin(lat * (PI()/180))
	) * 3959 as Dist
from TABLE_NAME
having Dist < radius
order by Dist

*/

// class to inject the field data into the page META-tags.
class CatalogGeolocationField extends Backend {

	public function parseValue($id, $k, $raw, $blnImageLink, $objCatalog, $objCatalogInstance)
	{
		return array
				(
					'items'	=> array(),
					'values' => false,
					'html'  => '',
				);
	}

	public function generateFieldEditor(&$field, $objRow)
	{
		foreach(array('remote_street', 'remote_city', 'remote_region', 'remote_country') as $fname)
			if($objRow->$fname)
			{
				$field['eval'][$fname] = $objRow->$fname;
			}
		return $field;
	}

	public function onSave($varValue, DataContainer $dc) {
		// migrate values to location table.
		$latLng=explode(',', $varValue);
		$objLatLong=$this->Database->prepare('SELECT * FROM tl_catalog_geolocation WHERE cat_id=? AND item_id=?')
									->execute($dc->activeRecord->pid, $dc->id);
		if($objLatLong->numRows)
			$this->Database->prepare('UPDATE tl_catalog_geolocation SET latitude=?, longitude=? WHERE cat_id=? AND item_id=?')
							->execute($latLng[0], $latLng[1], $dc->activeRecord->pid, $dc->id);
		else
			$this->Database->prepare('INSERT INTO tl_catalog_geolocation %s')
							->set(array('latitude'=>$latLng[0], 'longitude'=>$latLng[1], 'cat_id'=>$dc->activeRecord->pid, 'item_id'=>$dc->id))
							->execute();
		return $varValue;
	}

	public function onLoad($varValue, DataContainer $dc) {
		return $varValue;
	}
}
?>