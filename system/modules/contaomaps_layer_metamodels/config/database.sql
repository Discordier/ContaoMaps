-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the Contao    *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

--
-- Table `tl_catalog_geolocation`
--

CREATE TABLE `tl_metamodel_geolocation` (
-- id for this entry
  `id` int(10) unsigned NOT NULL auto_increment,
-- id of the attribute
  `att_id` int(10) unsigned NOT NULL default '0',
-- id of the item in the metamodel
  `item_id` int(10) unsigned NOT NULL default '0',
-- coords in map
  `latitude` float(10,7) NOT NULL default '0.0000000',
  `longitude` float(10,7) NOT NULL default '0.0000000'
  PRIMARY KEY  (`id`),
  KEY `att_item` (`att_id`, `item_id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_contaomap_layer`
--

CREATE TABLE `tl_contaomap_layer` (
  `metamodel` int(10) unsigned NOT NULL default '0',
  `metamodel_att` int(10) unsigned NOT NULL default '0',

-- LIMIT n,m for listings
  `metamodel_use_limit` char(1) NOT NULL default '',
  `metamodel_limit` smallint(5) NOT NULL default '0',
  `metamodel_offset` smallint(5) NOT NULL default '0',
-- filtering and sorting
  `metamodel_sortby` varchar(64) NOT NULL default '',
  `metamodel_sortby_direction` varchar(4) NOT NULL default '',
  `metamodel_filtering` int(10) NOT NULL default '0',
  `metamodel_rendersettings` int(10) NOT NULL default '0',
  `metamodel_noparsing` char(1) NOT NULL default '',
  `metamodel_filterparams` longblob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_metamodel_attribute` (
  `map_remote_street` int(10) NOT NULL default '0',
  `map_remote_city` int(10) NOT NULL default '0',
  `map_remote_region` int(10) NOT NULL default '0',
  `map_remote_country` int(10) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
