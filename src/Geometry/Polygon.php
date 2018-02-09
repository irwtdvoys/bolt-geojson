<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\GeoJson\Geometry;

	class Polygon extends Geometry
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				foreach ($this->coordinates as &$next)
				{
					$next = new LinearRing($next);
				}
			}
		}

		public function points()
		{
			$points = array();

			foreach ($this->coordinates as $linearRing)
			{
				$points = array_merge($points, $linearRing->points());
			}

			return $points;
		}

		public function add(LinearRing $ring)
		{
			$this->coordinates[] = $ring;
		}
	}
?>
