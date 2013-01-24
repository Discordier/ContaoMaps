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
$GLOBALS['TL_LANG']['tl_contaomap_layer']['editcatalogmarkers']= array('Marker bearbeiten', 'Marker des Kataloglayers %s bearbeiten');

// legend
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_legend']='Katalog Einstellungen';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog']= array('Katalog', 'Bitte wählen Sie den Katalog aus.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_template']= array('Template', 'Bitte wählen Sie ein Template aus.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_jumpTo']= array('Sprungseite', 'Bitte wählen Sie eine Zielseite aus, auf welche bei Auswahl eines Markers weitergeleitet werden soll.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_visible']= array('Sichtbare Felder', 'Bitte wählen Sie die sichtbaren Felder aus.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_where']= array('Filterkriterium', 'Bitte geben Sie zusätzliche Filterkriterien ein (z.B. published=1).');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_iconfield']= array('Icon Feld', 'Bitte wählen Sie das Feld, welches als "pro item" marker-icon verwendet werden soll. Soll keines vergeben werden, lassen Sie dies leer.');
$GLOBALS['TL_LANG']['tl_contaomap_layer']['catalog_icon']= array('Icon', 'Wählen Sie ein Icon für alle Einträge. Wenn Sie ein Icon Feld gewählt haben, wird dieses das hier gewählte Bild überschreiben.');

/**
 * Layer types
 */
$GLOBALS['TL_LANG']['tl_contaomap_layer']['types']['catalog']='Katalog layer';

?>