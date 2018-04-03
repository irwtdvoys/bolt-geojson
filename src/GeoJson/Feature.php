<?php
	namespace Bolt\GeoJson;

	use Bolt\Base;

	class Feature extends Base
	{
		public $type;
		public $geometry;
		public $properties;

		public $id = null;

		public function __construct($data = null)
		{
			$this->properties = new Properties($data->properties);

			parent::__construct($data);

			$this->type = $this->className(false);
		}

		public function toJson($type = "full")
		{
			$properties = $this->getProperties();

			foreach ($properties as $property)
			{
				$value = $this->{$property};

				if ($value !== null)
				{
					$subType = ($property == "coordinates") ? "simple" : "full";

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
						$results[$property] = $value;
					}
				}
			}

			if ($type == "simple")
			{
				$results = $results['coordinates'];
			}

			return json_encode($results);
		}

		public function geometry($data = null)
		{
			if ($data === null)
			{
				return $this->geometry;
			}

			$className = "\\Bolt\\GeoJson\\Geometry\\" . $data->type;

			$this->geometry = new $className($data);

			return true;
		}

		public function properties(\stdClass $data = null)
		{
			if ($data === null)
			{
				return $this->properties->properties;
			}

			$this->properties->properties($data);

			return true;
		}
	}
?>
