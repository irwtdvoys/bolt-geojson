<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\GeoJson\Geometry;

	class Point extends Geometry
	{
		public function __construct($data = null)
		{
			$this->coordinates(new Position());

			parent::__construct($data);
		}

		public function lat($value = null)
		{
			if ($value !== null)
			{
				$this->coordinates->lat($value);

				return $this;
			}

			return $this->coordinates->lat;
		}

		public function lng($value = null)
		{
			if ($value !== null)
			{
				$this->coordinates->lng($value);

				return $this;
			}

			return $this->coordinates->lng;
		}

		public function points(): array
		{
			return array($this);
		}

		public function coordinates($data = null)
		{
			if ($data === null)
			{
				return $this->coordinates;
			}

			if (is_array($data))
			{
				$this->coordinates = new Position($data);
			}
			else
			{
				$this->coordinates = $data;
			}

			return $this;
		}
	}
?>
