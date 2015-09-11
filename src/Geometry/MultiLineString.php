<?php
	namespace Bolt\GeoJson\Geometry;

	use \Bolt\GeoJson\Geometry;

	class MultiLineString extends Geometry
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			foreach ($this->coordinates as &$next)
			{
				$next = new LineString($next);
			}
		}

		public function points()
		{
			$points = array();

			foreach ($this->coordinates as $lineString)
			{
				$points = array_merge($points, $lineString->points());
			}

			return $points;
		}
	}
?>
