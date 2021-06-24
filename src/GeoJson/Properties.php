<?php
	namespace Bolt\GeoJson;

	use Bolt\Base;
	use Bolt\Json;
	use stdClass;

	class Properties extends Base
	{
		public stdClass $properties;

		public function __construct(stdClass $data = null)
		{
			$this->properties = ($data === null) ? new stdClass() : $data;
		}

		public function toJson(string $type = "full"): string
		{
			return Json::encode($this->properties);
		}

		public function properties(stdClass $data = null)
		{
			if ($data === null)
			{
				return $this->properties;
			}

			$this->properties = $data;

			return $this;
		}

		public function __call($name, $args)
		{
			if ($args == array())
			{
				return $this->properties->$name;
			}

			$this->properties->$name = $args[0];

			return $this;
		}
	}
?>
