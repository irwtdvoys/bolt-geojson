<?php
	namespace Bolt\GeoJson\Geometry;

	class LineString extends MultiPoint
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if (count($this->coordinates) < 2)
			{
				$this->coordinates = null;
			}
		}
	}
?>
