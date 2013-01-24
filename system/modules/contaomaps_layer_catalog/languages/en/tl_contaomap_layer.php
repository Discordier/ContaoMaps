<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL
 * @filesource
 */


// Operations
$GLOBALS['TL_LANG']['tl_contaomap_layer']['editcatalogmarkers']= array('Edit markers', 'Edit markers on layer %s');

// legend
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_legend']='Catalog settings';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog']= array('Catalog', 'Please select the catalog.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_template']= array('Template', 'Please select the template that shall be used to render the info bubble.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_jumpTo']= array('JumpTo page', 'Please select the jumpTo page to which the user shall get redirected when the marker has been clicked.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_visible']= array('Visible fields', 'Please select all visible fields.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_where']= array('Filter criteria', 'Please specify any filter you like in SQL notation (i.e. published=1).');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_iconfield']= array('Icon field', 'Please select the field that shall be used for the "per item" marker-icon (if any).');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_icon']= array('Icon', 'Use this icon for all entries. If you specify an icon field, that one will override this icon here.');

/**
 * Layer types
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['types']['catalog']='Catalog layer';

?>