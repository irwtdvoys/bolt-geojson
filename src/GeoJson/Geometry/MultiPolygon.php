<?php
	namespace Bolt\GeoJson\Geometry;

	use \Bolt\GeoJson\Geometry;

	class MultiPolygon extends Geometry
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				foreach ($this->coordinates as &$next)
				{
					$next = new Polygon($next);
				}
			}
		}

		public function points(): array
		{
			$points = array();

			foreach ($this->coordinates as $polygon)
			{
				$points = array_merge($points, $polygon->points());
			}

			return $points;
		}

		public function add(Polygon $polygon): self
		{
			$this->coordinates[] = $polygon;

			return $this;
		}
	}
?>
