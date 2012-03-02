<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL 
 * @filesource
 */

$GLOBALS['TL_LANG']['tl_catalog_fields']['typeOptions']['geolocation'] = 'Geolocation';

$GLOBALS['TL_LANG']['tl_catalog_fields']['catalog_maplegend'] = 'Geolocation settings';

$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_street'] = array('Remote field: street','Please specify which field shall automatically be updated with the street when the coordiantes have changed.');
$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_city'] = array('Remote field: city','Please specify which field shall automatically be updated with the city when the coordiantes have changed.');
$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_region'] = array('Remote field: state/region','Please specify which field shall automatically be updated with the state/region when the coordiantes have changed.');
$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_country'] = array('Remote field: country','Please specify which field shall automatically be updated with the country when the coordiantes have changed.');

?>