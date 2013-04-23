<?php

class MetaModelFilterRuleAreaFilter extends MetaModelFilterRuleSimpleQuery
{
	/**
	 * creates an instance of a simple query filter rule.
	 *
	 * @param string $strQueryString the query that shall be executed.
	 *
	 * @param array  $arrParams      the query parameters that shall be used.
	 */
	public function __construct($intAttrId, $strAreaFilter='')
	{
		$strQueryString = 'SELECT * FROM tl_metamodel_geolocation WHERE att_id=? AND ' . $strAreaFilter;
		parent::__construct($strQueryString, array($intAttrId), 'item_id');
	}
}

?>