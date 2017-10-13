<?php
	namespace Bolt\GeoJson\Geometry;

	use \Bolt\Base;
	use \Bolt\Arrays;

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

			$this->lat = (float)$this->lat;
			$this->lng = (float)$this->lng;
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
	}
?>
