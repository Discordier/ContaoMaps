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
$GLOBALS['TL_LANG']['tl_contaomap_layer']['editmetamodelmarkers']= array('Edit markers', 'Edit markers on layer %s');

/**
 * Layer types
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['types']['metamodel']='MetaModel layer';


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['mm_config_legend']				= 'MetaModel Configuration';
$GLOBALS['TL_LANG']['tl_contaomap_layer']['mm_filter_legend']				= 'MetaModel Filter';
$GLOBALS['TL_LANG']['tl_contaomap_layer']['mm_rendering']					= 'MetaModel Rendering';

/**
 * Selects
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['ASC']							= 'Ascending';
$GLOBALS['TL_LANG']['tl_contaomap_layer']['DESC']							= 'Descending';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel']						= array('MetaModel', 'The MetaModel to list in this listing.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_att']					= array('Geo location attribute', 'The MetaModel attribute to use as marker position.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_use_limit']			= array('Use offset and limit for listing', 'Check if you want to limit the amount of items listed. This is useful for only showing the first 500 items or all excluding the first 10 items but keep pagination intact.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_offset']				= array('List offset', 'Please specify the offset value (i.e. 10 to skip the first 10 items).');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_limit']				= array('Maximum number of items', 'Please enter the maximum number of items. Enter 0 to show all items and therefore disable the pagination.');

$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_sortby']				= array('Order by', 'Please choose the sort order.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_sortby_direction']		= array('Order by direction', 'Ascending or descending order.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_filtering']			= array('Filter settings to apply', 'Select the filter settings that shall get applied when compiling the list.');

$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_rendersettings']		= array('Render settings to apply', 'Select the rendering settings to use for generating the output. If left empty, the default settings for the selected metamodel will get applied. If no default has been defined, the output will only get the raw values.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_noparsing']			= array('No parsing of items', 'If this checkbox is selected, the module will not parse the items. Only the item-objects will be available in the template.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_filterparams']			= array('Filtersettings override');

$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_filterparams_use_get'] = array('Use GET Parameter', '');

/**
 * Wizards
 */

$GLOBALS['TL_LANG']['tl_contaomap_layer']['editmetamodel']            = array('Edit metamodel', 'Edit the metamodel ID %s.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['editrendersetting']        = array('Edit render setting', 'Edit the render setting ID %s.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['editfiltersetting']        = array('Edit filter setting', 'Edit the filter setting ID %s.');

?>