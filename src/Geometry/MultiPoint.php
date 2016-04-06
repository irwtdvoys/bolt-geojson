<?php
	namespace Bolt\GeoJson\Geometry;

	use \Bolt\GeoJson\Geometry;

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

		public function points()
		{
			return $this->coordinates;
		}
	}
?>
