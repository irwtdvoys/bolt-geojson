<?php
	namespace Bolt\GeoJson\Geometry;

	class Envelope extends MultiPoint
	{
		public function __construct($data = null)
		{
			if (gettype($data) == "object")
			{
				if (strpos(get_class($data), "Models\\GeoJson\\") === 0)
				{
					$data = $data->toEnvelope();
				}
			}

			parent::__construct($data);

			if ($data !== null)
			{
				if (count($this->coordinates) != 2)
				{
					throw new \Exception("Envelope requires at 2 points");
				}
			}
		}

		public function extend(Point $point)
		{
			if ($this->coordinates === null)
			{
				$this->coordinates = array(
					new Point(array("coordinates" => array($point->lng(), $point->lat()))),
					new Point(array("coordinates" => array($point->lng(), $point->lat())))
				);
			}
			else
			{
				if ($this->coordinates[0]->lng() - $point->lng() <= 180 && $this->coordinates[0]->lng() - $point->lng() >= 0)
				{
					$this->coordinates[0]->lng($point->lng());
				}
				elseif ($point->lng() - $this->coordinates[1]->lng() <= 180 && $point->lng() - $this->coordinates[1]->lng() >= 0)
				{
					$this->coordinates[1]->lng($point->lng());
				}

				if ($this->coordinates[1]->lat() - $point->lat() <= 90 && $this->coordinates[1]->lat() - $point->lat() >= 0)
				{
					$this->coordinates[1]->lat($point->lat());
				}
				elseif ($point->lat() - $this->coordinates[0]->lat() <= 90 && $point->lat() - $this->coordinates[0]->lat() >= 0)
				{
					$this->coordinates[0]->lat($point->lat());
				}
			}
		}

		public function toPoint()
		{
			$point = array(
				$this->coordinates[0]->lng() + (($this->coordinates[1]->lng() - $this->coordinates[0]->lng()) / 2),
				$this->coordinates[1]->lat() + (($this->coordinates[0]->lat() - $this->coordinates[1]->lat()) / 2)
			);

			return new Point($point);
		}

		public function toPolygon()
		{
			$ring = array(
				array($this->coordinates[0]->lng(), $this->coordinates[0]->lat()),
				array($this->coordinates[1]->lng(), $this->coordinates[0]->lat()),
				array($this->coordinates[1]->lng(), $this->coordinates[1]->lat()),
				array($this->coordinates[0]->lng(), $this->coordinates[1]->lat()),
				array($this->coordinates[0]->lng(), $this->coordinates[0]->lat())
			);

			return new Polygon(array($ring));
		}
	}
?>
