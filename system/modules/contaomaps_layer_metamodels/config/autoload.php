<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Contaomaps_layer_metamodels
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'MetaModelListContaoMaps'       => 'system/modules/contaomaps_layer_metamodels/MetaModelListContaoMaps.php',
	'ContaoMapLayerMetaModel'       => 'system/modules/contaomaps_layer_metamodels/ContaoMapLayerMetaModel.php',
	'MetaModelAttributeGeolocation' => 'system/modules/contaomaps_layer_metamodels/MetaModelAttributeGeolocation.php',
	'MetaModelFilterRuleAreaFilter' => 'system/modules/contaomaps_layer_metamodels/MetaModelFilterRuleAreaFilter.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mm_attr_geolocation' => 'system/modules/contaomaps_layer_metamodels/templates',
));
