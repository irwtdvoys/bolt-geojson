<?php
	namespace Bolt\GeoJson\Geometry;

	class LineString extends MultiPoint
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				if (count($this->coordinates) < 2)
				{
					throw new \Exception("LineString requires at least 2 points");
				}
			}
		}
	}
?>
