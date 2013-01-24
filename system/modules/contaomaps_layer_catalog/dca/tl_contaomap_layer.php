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
$GLOBALS['TL_DCA']['tl_contaomap_layer']['list']['operations'] = array_merge_recursive(array('editcatalogmarkers' => array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_contaomap_layer']['editcatalogmarkers'],
	'href'					=> 'markers',
	'icon'					=> 'system/modules/contaomaps/html/marker-edit.png',
	'button_callback'		=> array('tl_contaomap_layer_catalog', 'catalogButton')
)),
$GLOBALS['TL_DCA']['tl_contaomap_layer']['list']['operations']
);

// Palettes
$GLOBALS['TL_DCA']['tl_contaomap_layer']['palettes']['catalog'] = '{title_legend},name,alias,type,ignore_area_filter,mgrtype;{catalog_legend},catalog,catalog_template,catalog_jumpTo,catalog_visible,catalog_where,catalog_icon,catalog_iconfield,imageSize';

// Fields

$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog'],
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options_callback'        => array('tl_contaomap_layer_catalog','getCatalogsWithGeoLocation'),
	'eval'                    => array('mandatory'=> true, 'submitOnChange'=> true)
);

$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['catalog_template'],
	'default'                 => 'catalog_full',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_contaomap_layer_catalog','getCatalogTemplates'),
	'eval'                    => array('tl_class'=>'w50')
);


$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog_jumpTo'] = array
(
	'label'               => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_jumpTo'],
	'exclude'             => true,
	'inputType'           => 'pageTree',
	'explanation'         => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_jumpTo'][1],
	'eval'                => array('fieldType'=>'radio', 'helpwizard'=>true, 'tl_class' => 'clr'),
);

$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog_visible'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_visible'],
	'exclude'                 => true,
	'inputType'               => 'checkboxWizard',
	'options_callback'        => array('tl_contaomap_layer_catalog', 'getCatalogFields'),
	'eval'                    => array('multiple'=> true, 'mandatory'=> true)
);

$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog_where'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_where'],
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval'                    => array('decodeEntities'=>true, 'style'=>'height:80px;')
);

$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog_iconfield'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_iconfield'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_contaomap_layer_catalog', 'getCatalogImageFields'),
	'eval'                    => array()
);

$GLOBALS['TL_DCA']['tl_contaomap_layer']['fields']['catalog_icon'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_icon'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'tl_class'=>'clr')
);

class tl_contaomap_layer_catalog extends Backend
{

	public function catalogButton($row, $href, $label, $title, $icon, $attributes)
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

	public function getCatalogsWithGeoLocation(DataContainer $dc)
	{
		$objCatalogs = $this->Database->prepare('SELECT c.* FROM tl_catalog_types c, tl_catalog_fields cf WHERE cf.pid=c.id AND cf.type="geolocation"')->execute();
		$catalogs=array();
		while ($objCatalogs->next())
			$catalogs[$objCatalogs->id]=$objCatalogs->name;
		return $catalogs;
	}

	public function getCatalogTemplates(DataContainer $dc)
	{
		// unfortunately we are completely independent of any theme in here, we simply have no way to know from where this layer get's included.
		// Therefore we fetch all.
		$objThemes = $this->Database->prepare('SELECT id FROM tl_theme')->execute();
		$templates=array();
		return array_unique(array_merge($templates, $this->getTemplateGroup('contaomap_catalog')));
	}

	/**
	 * Get all catalog fields and return them as array
	 * @return array
	 */
	public function getCatalogFields(DataContainer $dc, $arrTypes=false, $blnImage=false)
	{
		if(!$arrTypes)
			$arrTypes=$GLOBALS['BE_MOD']['content']['catalog']['typesCatalogFields'];
		$fields = array();
		$chkImage = $blnImage ? " AND c.showImage=1" : "";

		$objFields = $this->Database->prepare("SELECT c.* FROM tl_catalog_fields c WHERE c.pid=? AND c.type IN ('" . implode("','", $arrTypes) . "')".$chkImage." ORDER BY c.sorting ASC")
							->execute($dc->activeRecord->catalog);

		while ($objFields->next())
		{
			$value = strlen($objFields->name) ? $objFields->name.' ' : '';
			$value .= '['.$objFields->colName.':'.$objFields->type.']';
			$fields[$objFields->colName] = $value;
		}

		return $fields;

	}

	/**
	 * Get all catalog image fields and return them as array
	 * @return array
	 */
	public function getCatalogImageFields(DataContainer $dc, $arrTypes=false)
	{
		if(!$arrTypes)
			$arrTypes=$GLOBALS['BE_MOD']['content']['catalog']['typesCatalogFields'];
		$fields = array('' => '-');

		$objFields = $this->Database->prepare("SELECT c.* FROM tl_catalog_fields c WHERE c.pid=? AND c.type IN ('" . implode("','", $arrTypes) . "') AND c.showImage=1 ORDER BY c.sorting ASC")
							->execute($dc->activeRecord->catalog);

		while ($objFields->next())
		{
			$value = strlen($objFields->name) ? $objFields->name.' ' : '';
			$value .= '['.$objFields->colName.':'.$objFields->type.']';
			$fields[$objFields->colName] = $value;
		}

		return $fields;

	}
}

?>