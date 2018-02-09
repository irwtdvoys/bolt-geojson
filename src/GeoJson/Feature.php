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
			$this->properties = new \stdClass();

			parent::__construct($data);

			if ($this->geometry !== null)
			{
				$geometry = "Bolt\\GeoJson\\Geometry\\" . $this->geometry->type;
				$this->geometry = new $geometry($this->geometry);
			}

			$this->type = $this->className(false);
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
	}
?>
