<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * PHP version 5
 * @copyright  Cyberspectrum 2012
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    ContaoMaps
 * @license    LGPL
 * @filesource
 */



/*
select *,
	acos(cos(centerLat * (PI()/180)) *
	 cos(centerLon * (PI()/180)) *
	 cos(lat * (PI()/180)) *
	 cos(lon * (PI()/180))
	 +
	 cos(centerLat * (PI()/180)) *
	 sin(centerLon * (PI()/180)) *
	 cos(lat * (PI()/180)) *
	 sin(lon * (PI()/180))
	 +
	 sin(centerLat * (PI()/180)) *
	 sin(lat * (PI()/180))
	) * 3959 as Dist
from TABLE_NAME
having Dist < radius
order by Dist

*/

// class to inject the field data into the page META-tags.
class MetaModelAttributeGeolocation extends MetaModelAttributeComplex
{

	/////////////////////////////////////////////////////////////////
	// interface IMetaModelAttribute
	/////////////////////////////////////////////////////////////////

	/**
	 * {@inheritdoc}
	 */
	public function getAttributeSettingNames()
	{
		return array_merge(parent::getAttributeSettingNames(), array(
			'map_remote_street',
			'map_remote_city',
			'map_remote_region',
			'map_remote_country'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFieldDefinition($arrOverrides = array())
	{
		// TODO: add tree support here.
		$arrFieldDef=parent::getFieldDefinition($arrOverrides);
		$arrFieldDef['inputType'] = 'geolookup';

		$arrFieldDef['eval']['includeBlankOption'] = true;
		$arrFieldDef['eval']['multiple'] = true;
		foreach(array('map_remote_street', 'map_remote_city', 'map_remote_region', 'map_remote_country') as $strField)
		{
			if($this->$strField)
			{
				$arrFieldDef['eval'][$strField] = $this->$strField;
			}
		}
		return $arrFieldDef;
	}


	/**
	 * {@inheritdoc}
	 */
	public function valueToWidget($varValue)
	{
		return ($varValue['latitude'] && $varValue['longitude']) ? implode(',', array($varValue['latitude'], $varValue['longitude'])) : '';
	}

	/**
	 * {@inheritdoc}
	 */
	public function widgetToValue($varValue, $intId)
	{
		$objDB = Database::getInstance();

		$arrValue = $objDB->prepare('
			SELECT *
			FROM tl_metamodel_geolocation
			WHERE att_id=? AND item_id=?'
		)
		->execute($this->get('id'), $intId)
		->row();

		list($arrValue['latitude'], $arrValue['longitude']) = explode(',', $varValue);

		return $arrValue;
	}

	/**
	 * {@inheritdoc}
	 *
	 * Returns no values as geolocation does not support filtering via options (as it is pretty useless)
	 *
	 */
	public function getFilterOptions($arrIds, $usedOnly)
	{
		return array();
	}

	/////////////////////////////////////////////////////////////////
	// interface IMetaModelAttributeComplex
	/////////////////////////////////////////////////////////////////

	public function getDataFor($arrIds)
	{
		$arrReturn = array();
		$objDB = Database::getInstance();

		$objValue = $objDB->prepare(sprintf('
			SELECT *
			FROM tl_metamodel_geolocation
			WHERE att_id=? AND item_id IN (%s)',
			implode(',', $arrIds)
		))
		->execute($this->get('id'));

		while ($objValue->next())
		{
			$arrReturn[$objValue->item_id] = $objValue->row();
		}
		return $arrReturn;
	}

	protected function sanitizeValue(&$arrValue)
	{
		if($arrValue === null)
		{
			$arrValue = array
			(
				'longitude'  => 0,
				'latitude'   => 0
			);
		}

		if($arrValue['longitude'] === null)
		{
			$arrValue['longitude'] = 0;
		}

		if($arrValue['latitude'] === null)
		{
			$arrValue['latitude'] = 0;
		}
	}

	public function setDataFor($arrValues)
	{
		$objDB = Database::getInstance();
		$arrItemIds = array_map('intval', array_keys($arrValues));
		sort($arrItemIds);
		// load all existing entries to be updated, keep the ordering to item Id
		// so we can benefit from the batch deletion and insert algorithm.
		$arrExistingItemIds = $objDB->prepare(sprintf('
		SELECT * FROM tl_metamodel_geolocation
		WHERE
		att_id=?
		AND item_id IN (%1$s)
		ORDER BY item_id ASC
		', implode(',', $arrItemIds)))
		->execute($this->get('id'))
		->fetchEach('item_id');

		$arrNewItemIds = array_diff($arrItemIds, $arrExistingItemIds);

		foreach ($arrNewItemIds as $intItemId)
		{
			$arrValue = $this->sanitizeValue($arrValues[$intItemId]);
			$objDB->prepare('UPDATE tl_metamodel_geolocation %s WHERE att_id=? AND item_id=?')
				  ->set($arrValue)
				  ->execute($this->get('id'), $intItemId);
		}

		foreach ($arrNewItemIds as $intItemId)
		{
			$arrValue = $this->sanitizeValue($arrValues[$intItemId]);
			$arrValue['att_id'] = $this->get('id');
			$arrValue['item_id'] = $intItemId;
			$objDB->prepare('INSERT INTO tl_metamodel_geolocation %s')
				  ->set($arrValue)
				  ->execute();
		}
	}

	public function unsetDataFor($arrIds)
	{
		// FIXME: unimplemented
		throw new Exception('MetaModelAttributeTags::unsetDataFor() is not yet implemented, please do it or find someone who can!', 1);
	}
}
?>