<?php
	namespace Bolt\GeoJson;

	use Bolt\Base;
	use Bolt\Arrays;
	use Bolt\GeoJson\Geometry\Envelope;
	use Bolt\GeoJson\Geometry\Point;
	use Bolt\Json;

	abstract class Geometry extends Base
	{
		public string $type;
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

		protected function populate($data): self
		{
			$properties = $this->getProperties();

			if (count($properties) > 0)
			{
				foreach ($properties as $property)
				{
					if (is_array($data))
					{
						$value = isset($data[$property]) ? $data[$property] : null;
					}
					else
					{
						$value = isset($data->{$property}) ? $data->{$property} : null;
					}

					if ($value !== null)
					{
						$this->{$property}($value);
					}
				}
			}

			return $this;
		}

		public function toJson($type = "full")
		{
			$properties = $this->getProperties();

			foreach ($properties as $property)
			{
				$value = $this->{$property};

				if ($value !== null)
				{
					$subType = ($property === "coordinates") ? "simple" : "full";

					if (is_array($value))
					{
						foreach ($value as &$element)
						{
							if (is_object($element) && get_class($element) != "stdClass")
							{
								$element = Json::decode($element->toJson($subType));
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
							$value = Json::decode($value->toJson($subType));
						}
					}

					if ($value !== null)
					{
						$results[$property] = $value;
					}
				}
			}

			if ($type === "simple")
			{
				$results = $results['coordinates'];
			}

			return Json::encode($results);
		}

		public function toEnvelope(): Envelope
		{
			return (new Envelope())->extend($this);
		}

		public function toPoint(): Point
		{
			return $this
				->toEnvelope()
				->toPoint();
		}

		abstract public function points();
	}
?>
