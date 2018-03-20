<?php
	namespace Bolt\GeoJson;

	use Bolt\Base;

	class Properties extends Base
	{
		public $properties;

		public function __construct(\stdClass $data = null)
		{
			$this->properties = $data;
		}

		public function toJson($type = "full")
		{
			return json_encode($this->properties);
		}

		public function properties(\stdClass $data = null)
		{
			if ($data === null)
			{
				return $this->properties;
			}

			$this->properties = $data;

			return true;
		}

		public function __call($name, $args)
		{
			if ($args == array())
			{
				return $this->properties->$name;
			}

			$this->properties->$name = $args[0];

			return true;
		}
	}
?>
