<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\GeoJson\Geometry;

	class MultiPoint extends Geometry
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				foreach ($this->coordinates as &$next)
				{
					$next = new Point($next);
				}
			}
		}

		public function points(): array
		{
			return $this->coordinates;
		}

		public function add(Point $point): self
		{
			$this->coordinates[] = $point;

			return $this;
		}

		public function toLinearRing(): LinearRing
		{
			$coordinates = $this->coordinates;
			$coordinates[] = $this->coordinates[0];

			return new LinearRing($coordinates);
		}
	}
?>
