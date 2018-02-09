<?php
	namespace Bolt\Exceptions\Codes;

	use Bolt\Codes;

	class GeoJson extends Codes
	{
		const UNKNOWN = 0;

		const LINEAR_RING_REQUIRES_AT_LEAST_4_POINTS = 10;
		const LINEAR_RING_FIRST_AND_LAST_POINTS_DONT_MATCH = 11;

		const LINE_STRING_REQUIRES_AT_LEAST_2_POINTS = 20;

		const ENVELOPE_REQUIRES_2_POINTS = 30;
	}
?>
