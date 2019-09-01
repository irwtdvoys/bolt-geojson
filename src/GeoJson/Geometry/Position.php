<?php
	namespace Bolt\GeoJson\Geometry;

	use Bolt\Arrays;
	use Bolt\Base;
	use Bolt\Exceptions\Codes\GeoJson as Codes;
	use Bolt\Exceptions\GeoJson as Exception;
	use Bolt\Json;

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

		public function toJson()
		{
			$output = array(
				$this->lng,
				$this->lat
			);

			if ($this->alt !== null)
			{
				$output[] = $this->alt;
			}

			return Json::encode($output);
		}

		public function lat($value = null)
		{
			if ($value === null)
			{
				return $this->lat;
			}

			if ($value > 90 || $value < -90)
			{
				throw new Exception("Latitude must be between 90 and -90", Codes::INVALID_COORDINATES);
			}

			$this->lat = (float)$value;

			return $this;
		}

		public function lng($value = null)
		{
			if ($value === null)
			{
				return $this->lng;
			}

			if ($value > 180 || $value < -180)
			{
				throw new Exception("Longitude must be between 180 and -180", Codes::INVALID_COORDINATES);
			}

			$this->lng = (float)$value;

			return $this;
		}
	}
?>
