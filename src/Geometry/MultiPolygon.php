<?php
	namespace Bolt\GeoJson\Geometry;

	use \Bolt\GeoJson\Geometry;

	class MultiPolygon extends Geometry
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			foreach ($this->coordinates as &$next)
			{
				$next = new Polygon(array("coordinates" => $next));
			}
		}

		public function points()
		{
			$points = array();

			foreach ($this->coordinates as $polygon)
			{
				$points = array_merge($points, $polygon->points());
			}

			return $points;
		}
	}
?>
