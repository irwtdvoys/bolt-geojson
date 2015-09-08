<?php
	namespace Bolt\GeoJson\Geometry;

	class LinearRing extends MultiPoint
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if (count($this->coordinates) < 4 || $this->first() != $this->last())
			{
				$this->coordinates = null;
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
