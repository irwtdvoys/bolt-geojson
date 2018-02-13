<?php
	namespace Bolt\GeoJson;

	use Bolt\Base;
	use Bolt\Arrays;

	abstract class Geometry extends Base
	{
		public $type;
		public $coordinates;

		public function __construct($data = null)
		{
			if (Arrays::type($data) == "numeric")
			{
				$data = array(
					"coordinates" => $data
				);
			}

			parent::__construct($data);

			$this->type = $this->className(false);
		}

		protected function populate($data)
		{
			$properties = $this->getProperties();

			if (count($properties) > 0)
			{
				foreach ($properties as $property)
				{
					if (is_array($data))
					{
						$value = isset($data[$property->name]) ? $data[$property->name] : null;
					}
					else
					{
						$value = isset($data->{$property->name}) ? $data->{$property->name} : null;
					}

					if ($value !== null)
					{
						$this->{$property->name}($value);
					}
				}
			}

			return true;
		}

		public function toJson($type = "full")
		{
			$properties = $this->getProperties();

			foreach ($properties as $property)
			{
				$value = $this->{$property->name};

				if ($value !== null)
				{
					$subType = ($property->name == "coordinates") ? "simple" : "full";

					if (is_array($value))
					{
						foreach ($value as &$element)
						{
							if (is_object($element) && get_class($element) != "stdClass")
							{
								$element = json_decode($element->toJson($subType));
							}
						}

						if ($value === array())
						{
							$value = null;
						}
					}

					if (is_object($value))
					{
						if (get_class($value) != "stdClass")
						{
							$value = json_decode($value->toJson($subType));
						}
					}

					if ($value !== null)
					{
						$results[$property->name] = $value;
					}
				}
			}

			if ($type == "simple")
			{
				$results = $results['coordinates'];
			}

			return json_encode($results);
		}

		public function toEnvelope()
		{
			$envelope = new Geometry\Envelope();

			foreach ($this->points() as $point)
			{
				$envelope->extend($point);
			}

			return $envelope;
		}

		public function toPoint()
		{
			$envelope = $this->toEnvelope();

			return $envelope->toPoint();
		}

		abstract public function points();
	}
?>
