<?php

// Analyze user agents claiming to be Opera

function bb2_opera($package)
{
	if (!array_key_exists('Accept', $package['headers_mixed'])) {
		return "17566707";
	}
	return false;
}

?>
