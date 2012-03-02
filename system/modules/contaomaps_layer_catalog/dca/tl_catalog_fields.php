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
 * Table tl_catalog_fields 
 */

// Palettes
$GLOBALS['TL_DCA']['tl_catalog_fields']['palettes']['geolocation'] = 'name,description,colName,type;{display_legend},insertBreak,width50;{catalog_maplegend:hide},remote_street,remote_city,remote_region,remote_country';


// register to catalog module that we provide the geolocationfield as field type.
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['type']['options'][] = 'geolocation';


/**
 * Table tl_catalog_fields 
 */
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['remote_street'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_street'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_catalog_fields_contaomap', 'getTextFields'),
	'eval'                    => array('mandatory'=> true, 'tl_class'=>'w50'),
);
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['remote_city'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_city'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_catalog_fields_contaomap', 'getTextFields'),
	'eval'                    => array('mandatory'=> true, 'tl_class'=>'w50'),
);
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['remote_region'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_region'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_catalog_fields_contaomap', 'getTextFields'),
	'eval'                    => array('mandatory'=> true, 'tl_class'=>'w50'),
);
$GLOBALS['TL_DCA']['tl_catalog_fields']['fields']['remote_country'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_catalog_fields']['remote_country'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_catalog_fields_contaomap', 'getTextFields'),
	'eval'                    => array('mandatory'=> true, 'tl_class'=>'w50'),
);

class tl_catalog_fields_contaomap extends Backend
{
	public function getTextFields(DataContainer $dc)
	{
		$objFields = $this->Database->prepare('SELECT name, colName FROM tl_catalog_fields WHERE pid=? AND type="text"')
				->execute($dc->activeRecord->pid);
		$result = array('' => '-');
		while ($objFields->next())
		{
			$result[$objFields->colName] = $objFields->name;
		}
		return $result;
	}
}

?>