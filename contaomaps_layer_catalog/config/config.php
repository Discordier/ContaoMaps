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
 * Back-end module
 */
 
// Register field type editor to catalog module.
$GLOBALS['BE_MOD']['content']['catalog']['fieldTypes']['geolocation'] = array
(
	'typeimage'    => 'system/modules/contaomaps/html/icon.gif',
	'fieldDef'     => array
	(
		'inputType' => 'geolookup',
		'eval'      => array
		(
			'alwaysSave' => true,
			'mandatory'   => true,
		),
		'save_callback' => array(array('CatalogGeolocationField', 'onSave')),
		'load_callback' => array(array('CatalogGeolocationField', 'onLoad')),
	),
	'sqlDefColumn' => "varchar(64) NOT NULL default ''",
	'parseValue' => array(array('CatalogGeolocationField', 'parseValue')),
	'generateFieldEditor' => array(array('CatalogGeolocationField', 'generateFieldEditor')),
);

$GLOBALS['BE_MOD']['content']['catalog']['typesCatalogFields'][] = 'geolocation';
$GLOBALS['BE_MOD']['content']['catalog']['typesMatchFields'][] = 'geolocation';
$GLOBALS['BE_MOD']['content']['catalog']['typesEditFields'][] = 'geolocation';

// register our layer type
$GLOBALS['CONTAOMAP_MAPLAYERS']['catalog'] = 'ContaoMapLayerCatalog';

?>