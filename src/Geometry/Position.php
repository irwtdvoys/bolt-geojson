<?php
	namespace Bolt\GeoJson\Geometry;

	use \Bolt\Base;
	use \Bolt\Arrays;

	class Position extends Base
	{
		public $lat = 0;
		public $lng = 0;

		public function __construct($data = null)
		{
			if (Arrays::type($data) == "numeric" && count($data) == 2)
			{
				$data = array(
					"lat" => $data[1],
					"lng" => $data[0]
				);
			}

			parent::__construct($data);

			$this->lat = (float)$this->lat;
			$this->lng = (float)$this->lng;
		}

		public function toJson($type = "api")
		{
			return json_encode(array($this->lng, $this->lat));
		}
	}
?>
