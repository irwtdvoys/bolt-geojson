<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\Exceptions\Codes\GeoJson as Codes;
	use Bolt\Exceptions\GeoJson as Exception;

	class LinearRing extends MultiPoint
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				if (count($this->coordinates) < 4)
				{
					throw new Exception(Codes::LINEAR_RING_REQUIRES_AT_LEAST_4_POINTS);
				}

				if ($this->first() != $this->last())
				{
					throw new Exception(Codes::LINEAR_RING_FIRST_AND_LAST_POINTS_DONT_MATCH);
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
