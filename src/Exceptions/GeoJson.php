<?php
	namespace Bolt\Exceptions;

	use Bolt\Exceptions\Codes\GeoJson as Codes;
	use Exception;

	class GeoJson extends Exception
	{
		protected $codes;

		public function __construct($code, Exception $previous = null)
		{
			$codes = new Codes();

			parent::__construct($codes->fromCode($code), $code, $previous);
		}
	}
?>
