<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\GeoJson\Geometry;

	class Point extends Geometry
	{
		public function __construct($data = null)
		{
			parent::__construct($data);

			if ($data !== null)
			{
				$this->coordinates(new Position($this->coordinates));
			}
		}

		public function lat($value = null)
		{
			if ($value !== null)
			{
				$this->coordinates->lat($value);

				return true;
			}

			return $this->coordinates->lat;
		}

		public function lng($value = null)
		{
			if ($value !== null)
			{
				$this->coordinates->lng($value);

				return true;
			}

			return $this->coordinates->lng;
		}

		public function points()
		{
			return array($this);
		}
	}
?>
