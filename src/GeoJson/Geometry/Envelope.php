<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\Exceptions\Codes\GeoJson as Codes;
	use Bolt\Exceptions\GeoJson as Exception;
	use Bolt\GeoJson\Geometry;

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
					throw new Exception("Envelope requires at least 2 points", Codes::INVALID_POINTS);
				}
			}
		}

		public function extend(Geometry $geometry): self
		{
			$points = $geometry->points();

			foreach ($points as $point)
			{
				if ($this->coordinates === null)
				{
					$this->coordinates = [
						new Point([$point->lng(), $point->lat()]),
						new Point([$point->lng(), $point->lat()])
					];
				}
				else
				{
					if ($this->left() - $point->lng() <= 180 && $this->left() - $point->lng() >= 0)
					{
						$this->left($point->lng());
					}
					elseif ($point->lng() - $this->right() <= 180 && $point->lng() - $this->right() >= 0)
					{
						$this->right($point->lng());
					}

					if ($this->bottom() - $point->lat() <= 90 && $this->bottom() - $point->lat() >= 0)
					{
						$this->bottom($point->lat());
					}
					elseif ($point->lat() - $this->top() <= 90 && $point->lat() - $this->top() >= 0)
					{
						$this->top($point->lat());
					}
				}
			}

			return $this;
		}

		public function toPoint(): Point
		{
			$point = array(
				$this->left() + (($this->right() - $this->left()) / 2),
				$this->bottom() + (($this->top() - $this->bottom()) / 2)
			);

			return new Point($point);
		}

		public function toPolygon(): Polygon
		{
			$ring = (new MultiPoint())
				->add(new Point([$this->left(), $this->top()]))
				->add(new Point([$this->right(), $this->top()]))
				->add(new Point([$this->right(), $this->bottom()]))
				->add(new Point([$this->left(), $this->bottom()]))
				->toLinearRing()
			;

			return (new Polygon())->add($ring);
		}

		public function top($data = null)
		{
			if ($data === null)
			{
				return $this->coordinates[0]->lat();
			}

			$this->coordinates[0]->lat($data);

			return $this;
		}

		public function bottom($data = null)
		{
			if ($data === null)
			{
				return $this->coordinates[1]->lat();
			}

			$this->coordinates[1]->lat($data);

			return $this;
		}

		public function left($data = null)
		{
			if ($data === null)
			{
				return $this->coordinates[0]->lng();
			}

			$this->coordinates[0]->lng($data);

			return $this;
		}

		public function right($data = null)
		{
			if ($data === null)
			{
				return $this->coordinates[1]->lng();
			}

			$this->coordinates[1]->lng($data);

			return $this;
		}
	}
?>
