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

CREATE TABLE `tl_catalog_geolocation` (
-- id for this entry
  `id` int(10) unsigned NOT NULL auto_increment,
-- id of the catalog
  `cat_id` int(10) unsigned NOT NULL default '0',
-- id of the item in the catalog 
  `item_id` int(10) unsigned NOT NULL default '0',
-- coords in map
  `latitude` float(10,7) NOT NULL default '0.0000000',
  `longitude` float(10,7) NOT NULL default '0.0000000'
  PRIMARY KEY  (`id`),
  KEY `cat_item` (`cat_id`, `item_id`),
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table `tl_contaomap_layer`
-- 

CREATE TABLE `tl_contaomap_layer` (
  `catalog` int(10) unsigned NOT NULL default '0',
  `catalog_template` varchar(64) NOT NULL default '',
  `catalog_jumpTo` smallint(5) unsigned NOT NULL default '0',
  `catalog_visible` blob NULL,
-- new catalog conditions
  `catalog_where` text NULL,
  `catalog_iconfield` varchar(32) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_catalog_fields` (
  `remote_street` varchar(64) NOT NULL default '',
  `remote_city` varchar(64) NOT NULL default '',
  `remote_region` varchar(64) NOT NULL default '',
  `remote_country` varchar(64) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
