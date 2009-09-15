<?php
/**
 * compare two array
 *
 * @param unknown_type $arr1
 * @param unknown_type $arr2
 * @return unknown
 */
function bread_compare($a, $b){
    if ($a['displayorder'] == $b['displayorder']) return 0;
    return ($a['displayorder'] < $b['displayorder']) ? -1 : 1;
}

/**
 * bread org
 *
 * @param unknown_type $breads
 * @return unknown
 */
function bread_array($breads, $seperate = " &gt; ")
{
	$bread = array();
    uasort($breads, "bread_compare");
    foreach ($breads as $key=>$val){
        if(!empty($val['url'])) {
            if(isset($val['params'])) $bread[] = "<a href='".$val['url'].queryString($val['params'])."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
            else $bread[] = "<a href='".$val['url']."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
        }else {
            $bread[] = $val['title'];
        }
    }
    return implode($seperate, $bread);
}

/**
 * Implements http_build_query for PHP4.
 *
 * @param string $data Data to set in query string
 * @param string $prefix If numeric indices, prepend this to index for elements in base array.
 * @param string $argSep String used to separate arguments
 * @param string $baseKey Base key
 * @return string URL encoded query string
 * @see http://php.net/http_build_query
 */
	if (!function_exists('http_build_query')) {
		function http_build_query($data, $prefix = null, $argSep = null, $baseKey = null) {
			if (empty($argSep)) {
				$argSep = ini_get('arg_separator.output');
			}
			if (is_object($data)) {
				$data = get_object_vars($data);
			}
			$out = array();

			foreach ((array)$data as $key => $v) {
				if (is_numeric($key) && !empty($prefix)) {
					$key = $prefix . $key;
				}
				$key = urlencode($key);

				if (!empty($baseKey)) {
					$key = $baseKey . '[' . $key . ']';
				}

				if (is_array($v) || is_object($v)) {
					$out[] = http_build_query($v, $prefix, $argSep, $key);
				} else {
					$out[] = $key . '=' . urlencode($v);
				}
			}
			return implode($argSep, $out);
		}
	}
/**
 * Generates a well-formed querystring from $q
 *
 * @param mixed $q Query string
 * @param array $extra Extra querystring parameters.
 * @param bool $escape Whether or not to use escaped &
 * @return array
 * @access public
 * @static
 */
	function queryString($q, $extra = array(), $escape = false) {
		if (empty($q) && empty($extra)) {
			return null;
		}
		$join = '&';
		if ($escape === true) {
			$join = '&amp;';
		}
		$out = '';

		if (is_array($q)) {
			$q = array_merge($extra, $q);
		} else {
			$out = $q;
			$q = $extra;
		}
		$out .= http_build_query($q, null, $join);
		if (isset($out[0]) && $out[0] != '?') {
			$out = '?' . $out;
		}
		return $out;
	}	
?>