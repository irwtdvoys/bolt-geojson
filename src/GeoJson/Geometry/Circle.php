<?php
	namespace Bolt\GeoJson\Geometry;

	class Circle extends Point
	{
		public int $radius;

		const EARTH = 6378137;

		public function toEnvelope(): Envelope
		{
			$delta = array(
				"lat" => $this->radius / self::EARTH,
				"lng" => $this->radius / (self::EARTH * cos(deg2rad($this->coordinates->lat)))
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

		public function toPoint(): Point
		{
			return new Point(array(
				"coordinates" => $this->coordinates
			));
		}

		public function points(): array
		{
			return array($this->toPoint());
		}
	}
?>
