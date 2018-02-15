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
					throw new Exception("Linear Ring requires at least 4 points", Codes::INVALID_POINTS);
				}

				if ($this->first() != $this->last())
				{
					throw new Exception("Linear Ring first and last points don't match", Codes::INVALID_POINTS);
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
