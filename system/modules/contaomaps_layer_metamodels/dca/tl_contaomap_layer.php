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
 * Table tl_contaomap_layer
 */

// operations
$GLOBALS['TL_DCA']['tl_contaomap_layer']['list']['operations'] = array_merge_recursive(array('editmetamodelmarkers' => array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_contaomap_layer']['editcatalogmarkers'],
	'href'					=> 'markers',
	'icon'					=> 'system/modules/contaomaps/html/marker-edit.png',
	'button_callback'		=> array('tl_contaomap_layer_metamodels', 'markerButton')
)),
$GLOBALS['TL_DCA']['tl_contaomap_layer']['list']['operations']
);

// Palettes
$GLOBALS['TL_DCA']['tl_contaomap_layer']['palettes']['metamodel'] = '{title_legend},name,alias,type,ignore_area_filter,mgrtype;{mm_config_legend},metamodel,metamodel_att,perPage,metamodel_use_limit;{mm_filter_legend},metamodel_sortby,metamodel_sortby_direction,metamodel_filtering,metamodel_filterparams;{mm_rendering},metamodel_rendersettings,metamodel_noparsing;';

$GLOBALS['TL_DCA']['tl_contaomap_layer']['palettes']['__selector__'][] = 'metamodel_use_limit';

// Insert new Subpalettes after position 1
array_insert($GLOBALS['TL_DCA']['tl_contaomap_layer']['subpalettes'], 1, array(
	'metamodel_use_limit' => 'metamodel_offset,metamodel_limit',
));

// Fields

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_contaomap_layer']['fields'], 1, array(
	'metamodel' => array
	(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel'],
		'exclude' => true,
		'inputType' => 'select',
		'options_callback' => array('tl_contaomap_layer_metamodels','getMetaModelsWithGeoLocation'),
		'eval' => array
			(
			'mandatory' => true,
			'submitOnChange' => true,
			'tl_class' => 'w50',
			'includeBlankOption' => true,
		),
		'wizard' => array
			(
			array('tl_contaomap_layer_metamodels', 'editMetaModel')
		)
	),

	'metamodel_att' => array
	(
		'label'                 => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_att'],
		'exclude'                 => true,
		'inputType'             => 'select',
		'options_callback'      => array('tl_contaomap_layer_metamodels','getGeolocationAttributeNames'),
		'eval' => array
		(
			'includeBlankOption' => true,
			'chosen'            => 'true',
			'tl_class' => 'w50'
		)
	),

	'metamodel_use_limit' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_use_limit'],
		'exclude' => true,
		'inputType' => 'checkbox',
		'eval' => array('submitOnChange' => true, 'tl_class' => 'w50 m12'),
	),
	'metamodel_limit' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_limit'],
		'exclude' => true,
		'inputType' => 'text',
		'eval' => array('rgxp' => 'digit', 'tl_class' => 'w50')
	),
	'metamodel_offset' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_offset'],
		'exclude' => true,
		'inputType' => 'text',
		'eval' => array('rgxp' => 'digit', 'tl_class' => 'w50'),
	),
	'metamodel_sortby' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_sortby'],
		'exclude' => true,
		'inputType' => 'select',
		'options_callback' => array('tl_contaomap_layer_metamodels', 'getSortingAttributeNames'),
		'eval' => array('includeBlankOption' => true, 'tl_class' => 'w50'),
	),
	'metamodel_sortby_direction' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_sortby_direction'],
		'exclude' => true,
		'inputType' => 'select',
		'reference' => &$GLOBALS['TL_LANG']['tl_content'],
		'options' => array('ASC' => 'ASC', 'DESC' => 'DESC'),
		'eval' => array('includeBlankOption' => false, 'tl_class' => 'w50'),
	),
	'metamodel_filtering' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_filtering'],
		'exclude' => true,
		'inputType' => 'select',
		'options_callback' => array('tl_contaomap_layer_metamodels', 'getFilterSettings'),
		'default' => '',
		'eval' => array
			(
			'includeBlankOption' => true,
			'submitOnChange' => true,
			'tl_class' => 'clr'
		),
		'wizard' => array
			(
			array('tl_contaomap_layer_metamodels', 'editFilterSetting')
		)
	),
	'metamodel_rendersettings' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_rendersettings'],
		'exclude' => true,
		'inputType' => 'select',
		'options_callback' => array('tl_contaomap_layer_metamodels', 'getRenderSettings'),
		'default' => '',
		'eval' => array
			(
			'includeBlankOption' => true,
			'submitOnChange' => true,
			'tl_class' => 'w50'
		),
		'wizard' => array
			(
			array('tl_contaomap_layer_metamodels', 'editRenderSetting')
		)
	),
	'metamodel_noparsing' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_noparsing'],
		'exclude' => true,
		'inputType' => 'checkbox',
		'eval' => array
			(
			'submitOnChange' => true,
			'tl_class' => 'w50'
		),
	),
	'metamodel_filterparams' => array
		(
		'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_filterparams'],
		'exclude' => true,
		'inputType' => 'mm_subdca',
		'eval' => array
		(
			'tl_class' => 'clr m12',
			'flagfields' => array
			(
				'use_get' => array
				(
					'label' => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['metamodel_filterparams_use_get'],
					'inputType' => 'checkbox'
				),
			),
		)
	)
));

class tl_contaomap_layer_metamodels extends Backend
{

	public function markerButton($row, $href, $label, $title, $icon, $attributes)
	{
		if($row['type']=='catalog')
		{
			switch($href)
			{
				case 'markers':
					$href='do=catalog&catid='.$row['catalog'].'&table=tl_catalog_items';
					break;
			}
			return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
		}
		else return '';
	}

	public function getMetaModelsWithGeoLocation(DataContainer $dc)
	{
		$objCatalogs = $this->Database->prepare('SELECT id,name FROM tl_metamodel')->execute();
		$catalogs=array();
		// TODO: filter for geo location attributes here.
		while ($objCatalogs->next())
			$catalogs[$objCatalogs->id]=$objCatalogs->name;
		return $catalogs;
	}

	public function buildCustomFilter($objDC)
	{
		// Check if we have a id, no create mode
		if (is_null($objDC->id))
		{
			unset($GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['metamodel_filterparams']);
			return;
		}

		// Get basic informations
		$objLayer = $this->Database
				->prepare('SELECT type, metamodel, metamodel_filtering FROM tl_contaomap_layer WHERE id=?')
				->limit(1)
				->execute($objDC->id);

		$intMetaModel = $objLayer->metamodel;
		$intFilter = $objLayer->metamodel_filtering;

		// Check if we have a row/metaModelconten/MetaModel/Filter
		if ($objLayer->numRows == 0 || $objLayer->type != 'metamodel' || empty($intMetaModel) || empty($intFilter))
		{
			unset($GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['metamodel_filterparams']);
			return;
		}

		$objFilter = $objFilterSettings = MetaModelFilterSettingsFactory::byId($intFilter);
		$arrParams = $objFilter->getParameterDCA();
		$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['metamodel_filterparams']['eval']['subfields'] = $arrParams;
	}

	/**
	 * Return the edit wizard
	 * @param DataContainer $objDC the datacontainer
	 * @return string
	 */
	public function editMetaModel(DataContainer $objDC)
	{
		return ($objDC->value < 1) ? '' : sprintf(
			'<a href="contao/main.php?%s&amp;act=edit&amp;id=%s" title="%s" style="padding-left:3px">%s</a>',
			'do=metamodels',
			$objDC->value,
			sprintf(specialchars($GLOBALS['TL_LANG']['tl_contaomap_layer']['editmetamodel'][1]), $objDC->value),
			$this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_contaomap_layer']['editmetamodel'][0], 'style="vertical-align:top"')
		);
	}

	/**
	 * Fetch all attribute names for the current metamodel
	 *
	 * @param DataContainer $objDC the datacontainer calling this method.
	 *
	 * @param array         $arrTypes a list of valid attribute type names.
	 *
	 * @return string[string] array of all attributes as colName => human name
	 */
	public function getAttributeNames(DataContainer $objDC, $arrTypes = array(), $blnIdAsKey = false)
	{
		$objMetaModel = MetaModelFactory::byId($objDC->activeRecord->metamodel);
		$arrAttributeNames = array();
		if ($objMetaModel)
		{
			foreach ($objMetaModel->getAttributes() as $objAttribute)
			{
				if(empty($arrTypes) || in_array($objAttribute->get('type'), $arrTypes))
				{
					$arrAttributeNames[($blnIdAsKey ? $objAttribute->get('id') : $objAttribute->getColName())] = $objAttribute->getName();
				}
			}
		}

		return $arrAttributeNames;
	}

	/**
	 * Fetch all attribute names for the current metamodel
	 *
	 * @param DataContainer $objDC the datacontainer calling this method.
	 *
	 * @return string[string] array of all attributes as colName => human name
	 */
	public function getGeolocationAttributeNames(DataContainer $objDC)
	{
		return $this->getAttributeNames($objDC, array('geolocation'), true);
	}

	/**
	 * Fetch all attribute names for the current metamodel in addition to the internal "sorting" field.
	 *
	 * @param DataContainer $objDC the datacontainer calling this method.
	 *
	 * @return string[string] array of all attributes as colName => human name
	 */
	public function getSortingAttributeNames(DataContainer $objDC)
	{
		return array_merge(array('sorting' => $GLOBALS['TL_LANG']['MSC']['sorting']), $this->getAttributeNames($objDC));
	}

	/**
	 * Return the edit wizard
	 * @param DataContainer $objDC the datacontainer
	 * @return string
	 */
	public function editRenderSetting(DataContainer $objDC)
	{
		return ($objDC->value < 1) ? '' : sprintf(
			'<a href="contao/main.php?%s&amp;act=edit&amp;id=%s" title="%s" style="padding-left:3px">%s</a>',
			'do=metamodels&table=tl_metamodel_rendersettings',
			$objDC->value,
			sprintf(specialchars($GLOBALS['TL_LANG']['tl_contaomap_layer']['editrendersetting'][1]), $objDC->value),
			$this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_contaomap_layer']['editrendersetting'][0], 'style="vertical-align:top"')
		);
	}

	/**
	 * Return the edit wizard
	 * @param DataContainer $objDC the datacontainer
	 * @return string
	 */
	public function editFilterSetting(DataContainer $objDC)
	{
		return ($objDC->value < 1) ? '' : sprintf(
			'<a href="contao/main.php?%s&amp;act=edit&amp;id=%s" title="%s" style="padding-left:3px">%s</a>',
			'do=metamodels&table=tl_metamodel_filter',
			$objDC->value,
			sprintf(specialchars($GLOBALS['TL_LANG']['tl_contaomap_layer']['editfiltersetting'][1]), $objDC->value),
			$this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_contaomap_layer']['editfiltersetting'][0], 'style="vertical-align:top"')
		);



	}

	/**
	 * Fetch all available filter settings for the current meta model.
	 *
	 * @param DataContainer $objDC the datacontainer calling this method.
	 *
	 * @return string[int] array of all attributes as id => human name
	 */
	public function getFilterSettings(DataContainer $objDC)
	{
		$objDB = Database::getInstance();
		$objFilterSettings = $objDB->prepare('SELECT * FROM tl_metamodel_filter WHERE pid=?')->execute($objDC->activeRecord->metamodel);
		$arrSettings = array();
		while ($objFilterSettings->next())
		{
			$arrSettings[$objFilterSettings->id] = $objFilterSettings->name;
		}

		//sort the filtersettings
		asort($arrSettings);
		return $arrSettings;
	}

	/**
	 * Fetch all available render settings for the current meta model.
	 *
	 * @param DataContainer $objDC the datacontainer calling this method.
	 *
	 * @return string[int] array of all attributes as id => human name
	 */
	public function getRenderSettings($objDC)
	{
		$objDB = Database::getInstance();
		$objFilterSettings = $objDB->prepare('SELECT * FROM tl_metamodel_rendersettings WHERE pid=?')->execute($objDC->activeRecord->metamodel);

		$arrSettings = array();
		while ($objFilterSettings->next())
		{
			$arrSettings[$objFilterSettings->id] = $objFilterSettings->name;
		}

		//sort the rendersettings
		asort($arrSettings);
		return $arrSettings;
	}
}

?>