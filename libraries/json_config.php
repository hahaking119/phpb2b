<?php
require(PHPB2B_ROOT. "libraries/JSON.php");
// Future-friendly json_encode
if( !function_exists('json_encode') ) {
    function json_encode($data) {
        $json = new Services_JSON();
        return( $json->encode($data) );
    }
}
// Future-friendly json_decode
if( !function_exists('json_decode') )
{
	function json_decode($data, $output_mode=false) {
		$param = $output_mode ? 16:null;
		$json = new Services_JSON($param);
		return( $json->decode($data) );
	}
}


/**
 * return to ajax for the executed result
 *
 * @param Array $data
 */
function ajax_exit($data)
{
	echo json_encode($data);
	exit;
}
?>
