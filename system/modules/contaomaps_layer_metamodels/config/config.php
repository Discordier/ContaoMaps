<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL
 * @filesource
 */


$GLOBALS['METAMODELS']['attributes']['geolocation'] = array
(
	'class' => 'MetaModelAttributeGeolocation',
	'image' => 'system/modules/contaomaps/html/marker-edit.png'
);

// register our layer type
$GLOBALS['CONTAOMAP_MAPLAYERS']['metamodel'] = 'ContaoMapLayerMetaModel';

?>