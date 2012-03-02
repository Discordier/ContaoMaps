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
 * Class ContaoMapLayerDemo - a Demo for the new hook based mapping.
 *
 * @copyright  Cyberspectrum 2009
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @package    Controller
 */

class ContaoMapLayerDemo extends ContaoMapLayer
{
	/**
	 * This makes the layer generate a simple polygon of the shape of Baden-Wuerttemberg/Germany.
	 * @param array $omitObjects this array holds all objects already known to the map and that therefore shall not be returned.
	 * @return void
	 */
	public function assembleObjects($omitObjects)
	{
		// add a polygon defining Baden-Wuerttemberg in Germany.
		if(in_array('bw', $omitObjects))
			return;
		$strClass=$GLOBALS['CONTAOMAP_MAPOBJECTS']['polygon'];
		if(!$strClass)
			return;
		$objPolygon = new $strClass(array(
			'jsid' => 'bw'
		));
		$this->add($objPolygon);
		$objPolygon->strokecolor = '#000000';
		$objPolygon->strokeopacity = 0.9;
		$objPolygon->fillcolor = '#000000';
		$objPolygon->fillopacity = '0.2';
		$objPolygon->points=array(
array(49.660107, 9.4232964),
array(49.712000, 9.427632),
array(49.767530, 9.3235663),
array(49.7862, 9.4877782),
array(49.756899, 9.5676462),
array(49.787532, 9.6556269),
array(49.697873, 9.6315686),
array(49.683046, 9.6605225),
array(49.72444, 9.7157727),
array(49.683605, 9.7346556),
array(49.721371, 9.8016552),
array(49.699271, 9.8369034),
array(49.639825, 9.8392813),
array(49.603038, 9.8805441),
array(49.550725, 9.8255736),
array(49.539955, 9.8658573),
array(49.581218, 9.9212474),
array(49.477851, 9.941948),
array(49.478411, 10.010347),
array(49.538137, 10.088116),
array(49.468479, 10.124484),
array(49.442463, 10.102523),
array(49.391549, 10.172460),
array(49.380079, 10.121546),
array(49.335739, 10.111336),
array(49.314199, 10.15749),
array(49.19992, 10.131617),
array(49.142573, 10.264218),
array(49.098233, 10.230788),
array(49.091240, 10.259602),
array(49.039906, 10.260441),
array(49.018925, 10.358493),
array(48.93835, 10.467035),
array(48.809114, 10.455006),
array(48.776244, 10.42115),
array(48.69791, 10.493891),
array(48.668681, 10.460041),
array(48.702250, 10.426331),
array(48.673436, 10.35863),
array(48.710363, 10.279184),
array(48.662666, 10.267715),
array(48.614549, 10.330238),
array(48.611192, 10.30184),
array(48.522512, 10.301564),
array(48.519435, 10.2335),
array(48.500832, 10.244915),
array(48.466283, 10.178055),
array(48.459709, 10.037902),
array(48.38417, 9.9716020),
array(48.28556, 10.068394),
array(48.185137, 10.086298),
array(48.103590, 10.142807),
array(48.028758, 10.137912),
array(47.972249, 10.088536),
array(47.882729, 10.105741),
array(47.871260, 10.078185),
array(47.823143, 10.133715),
array(47.792651, 10.07315),
array(47.755584, 10.117350),
array(47.676975, 10.12854),
array(47.638510, 10.073010),
array(47.691102, 10.024054),
array(47.653756, 9.9644684),
array(47.679073, 9.8440370),
array(47.607458, 9.7466848),
array(47.605499, 9.637303),
array(47.537521, 9.5645690),
array(47.662288, 9.2666376),
array(47.687186, 9.0040944),
array(47.656553, 8.8882788),
array(47.741597, 8.8063127),
array(47.719776, 8.7695259),
array(47.679353, 8.7955424),
array(47.698935, 8.736235),
array(47.735162, 8.7063029),
array(47.768732, 8.7212694),
array(47.811114, 8.5647505),
array(47.783419, 8.5650303),
array(47.775586, 8.4860016),
array(47.708027, 8.413546),
array(47.660190, 8.4346678),
array(47.672639, 8.5633518),
array(47.616410, 8.6026564),
array(47.599765, 8.5570575),
array(47.637670, 8.5178928),
array(47.605080, 8.4573274),
array(47.578504, 8.4813857),
array(47.569412, 8.42165),
array(47.624242, 8.197301),
array(47.561859, 8.0936553),
array(47.550249, 7.913777),
array(47.592071, 7.8951743),
array(47.593890, 7.8185234),
array(47.536542, 7.6947351),
array(47.552627, 7.6443805),
array(47.596967, 7.6849439),
array(47.58060, 7.6214411),
array(47.660050, 7.5235294),
array(47.877414, 7.5554207),
array(47.960919, 7.6185038),
array(48.030296, 7.579618),
array(48.119116, 7.5810176),
array(48.226120, 7.6726350),
array(48.297316, 7.6899793),
array(48.33452, 7.7477473),
array(48.401801, 7.733620),
array(48.519715, 7.807333),
array(48.585176, 7.8059348),
array(48.761417, 7.972804),
array(48.812891, 8.1007889),
array(48.899333, 8.1424713),
array(48.968710, 8.2359071),
array(49.099632, 8.3622132),
array(49.254053, 8.4146659),
array(49.293777, 8.4860016),
array(49.332802, 8.4504736),
array(49.360217, 8.4945339),
array(49.393367, 8.4990098),
array(49.392248, 8.4648806),
array(49.441484, 8.508521),
array(49.446799, 8.4514527),
array(49.585554, 8.4290729),
array(49.52470, 8.5857316),
array(49.544151, 8.6195811),
array(49.613249, 8.6004184),
array(49.630593, 8.6861611),
array(49.561216, 8.693714),
array(49.522191, 8.7348372),
array(49.511281, 8.9021263),
array(49.470717, 8.8681370),
array(49.477152, 8.8277134),
array(49.404137, 8.8176425),
array(49.460786, 8.9494037),
array(49.508483, 8.9600341),
array(49.520373, 9.1333378),
array(49.546109, 9.0923548),
array(49.583036, 9.1089998),
array(49.579120, 9.235865),
array(49.645560, 9.2976896),
array(49.660107, 9.4232964),
);
	}
}

?>