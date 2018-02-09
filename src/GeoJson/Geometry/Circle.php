<?php
	namespace Bolt\GeoJson\Geometry;

	class Circle extends Point
	{
		public $radius;

		public function toEnvelope()
		{
			$earth = 6378137;

			$delta = array(
				"lat" => $this->radius / $earth,
				"lng" => $this->radius / ($earth * cos(deg2rad($this->coordinates->lat)))
			);

			$envelope = array(
				"coordinates" => array(
					new Point(array(
						$this->coordinates->lng - rad2deg($delta['lng']),
						$this->coordinates->lat + rad2deg($delta['lat'])
					)),
					new Point(array(
						$this->coordinates->lng + rad2deg($delta['lng']),
						$this->coordinates->lat - rad2deg($delta['lat'])
					))
				)
			);

			return new Envelope($envelope);
		}

		public function toPoint()
		{
			return new Point(array(
				"coordinates" => $this->coordinates
			));
		}

		public function points()
		{
			return array($this->toPoint());
		}
	}
?>
