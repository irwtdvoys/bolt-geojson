<?php
	namespace Bolt\GeoJson;

	use Bolt\Base;
	use Bolt\Json;

	class GeometryCollection extends Base
	{
		public $type;
		public $geometries = array();

		public function __construct($data = null)
		{
			parent::__construct($data);

            if (!empty($this->geometries))
            {
            	foreach ($this->geometries as &$geometry)
				{
					$className = "\\Bolt\\GeoJson\\Geometry\\" . $geometry->type;

					$geometry = new $className($geometry);
				}
            }

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

			if ($type == "simple")
			{
				$results = $results['coordinates'];
			}

			return Json::encode($results);
		}

		public function add(Geometry $geometry)
		{
			$this->geometries[] = $geometry;
		}
	}
?>
