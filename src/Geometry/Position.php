<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\Base;
	use Bolt\Arrays;

	class Position extends Base
	{
		public $lat = 0;
		public $lng = 0;
		public $alt = null;

		public function __construct($data = null)
		{
			if (Arrays::type($data) == "numeric" && count($data) >= 2)
			{
				$data = array(
					"lat" => $data[1],
					"lng" => $data[0],
					"alt" => isset($data[2]) ? $data[2] : null
				);
			}

			parent::__construct($data);
		}

		public function toJson($type = "api")
		{
			$output = array(
				$this->lng,
				$this->lat
			);

			if ($this->alt !== null)
			{
				$output[] = $this->alt;
			}

			return json_encode($output);
		}

		public function lat($value = null)
		{
			if ($value === null)
			{
				return $this->lat;
			}

			$this->lat = (float)$value;

			return true;
		}

		public function lng($value = null)
		{
			if ($value === null)
			{
				return $this->lng;
			}

			$this->lng = (float)$value;

			return true;
		}
	}
?>
