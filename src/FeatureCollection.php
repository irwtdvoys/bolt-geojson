<?php
	namespace Bolt\GeoJson;

	use \Bolt\Base;

	class FeatureCollection extends Base
	{
		public $type;
		public $features;

		public function __construct($data = null)
		{
			parent::__construct($data);

			$this->features = array();

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
