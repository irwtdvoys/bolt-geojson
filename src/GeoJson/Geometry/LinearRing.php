<?php
	namespace Bolt\GeoJson\Geometry;

	class LinearRing extends MultiPoint
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				if (count($this->coordinates) < 4)
				{
					throw new \Exception("LinearRing requires at least 4 points");
				}

				if ($this->first() != $this->last())
				{
					throw new \Exception("First and last points must match");
				}
			}
		}

		private function first()
		{
			return $this->coordinates[0];
		}

		private function last()
		{
			return $this->coordinates[count($this->coordinates) - 1];
		}
	}
?>
