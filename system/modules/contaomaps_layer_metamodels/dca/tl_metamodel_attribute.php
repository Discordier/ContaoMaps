<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage AttributeSelect
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  CyberSpectrum
 * @license    private
 * @filesource
 */
if (!defined('TL_ROOT'))
{
	die('You cannot access this file directly!');
}

/**
 * Table tl_metamodel_attribute
 */

$GLOBALS['TL_DCA']['tl_metamodel_attribute']['metapalettes']['geolocation extends _simpleattribute_'] = array
(
	'+display' => array('map_remote_street', 'map_remote_city', 'map_remote_region', 'map_remote_country')
);

/**
 * Table tl_catalog_fields
 */
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['map_remote_street'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['map_remote_street'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_metamodel_attribute_geolocation', 'getTextFields'),
	'eval'                    => array('tl_class'=>'w50'),
);
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['map_remote_city'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['map_remote_city'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_metamodel_attribute_geolocation', 'getTextFields'),
	'eval'                    => array('tl_class'=>'w50'),
);
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['map_remote_region'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['map_remote_region'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_metamodel_attribute_geolocation', 'getTextFields'),
	'eval'                    => array('tl_class'=>'w50'),
);
$GLOBALS['TL_DCA']['tl_metamodel_attribute']['fields']['map_remote_country'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_metamodel_attribute']['map_remote_country'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_metamodel_attribute_geolocation', 'getTextFields'),
	'eval'                    => array('tl_class'=>'w50'),
);

class tl_metamodel_attribute_geolocation extends Backend
{
	public function getTextFields(DataContainer $dc)
	{
		$objFields = $this->Database->prepare('SELECT name, colName FROM tl_metamodel_attribute WHERE pid=? AND type="text"')
				->execute($dc->getCurrentModel()->getProperty('pid'));
		$result = array('' => '-');
		while ($objFields->next())
		{
			$result[$objFields->colName] = $objFields->name;
		}
		return $result;
	}
}


?>