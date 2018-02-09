<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\Exceptions\Codes\GeoJson as Codes;
	use Bolt\Exceptions\GeoJson as Exception;

	class LineString extends MultiPoint
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				if (count($this->coordinates) < 2)
				{
					throw new Exception(Codes::LINE_STRING_REQUIRES_AT_LEAST_2_POINTS);
				}
			}
		}

		public function simplify()
		{
			// Ramer-Douglas-Peuker
			// Convex Hull
		}
	}
?>
