<?php
class XML {
    var $parser;
    var $document;
    var $parent;
    var $stack;
    var $last_opened_tag;

    function XML() {

        $this->parser = xml_parser_create();
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, true);
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'open','close');
        xml_set_character_data_handler($this->parser, 'data');
    }
    function destruct() {
     xml_parser_free($this->parser);
    }
    function & parse(&$data) {
        $this->document = array();
        $this->stack    = array();
        $this->parent   = &$this->document;
        $parse = xml_parse($this->parser, $data, true) ? $this->document : NULL;
        return $parse;
    }
    function open(&$parser, $tag, $attributes) {
        $this->data = '';
        $this->last_opened_tag = $tag;
        if (is_array($this->parent) and array_key_exists($tag,$this->parent)) {
            if (is_array($this->parent[$tag]) and array_key_exists(0,$this->parent[$tag])) {
             if (is_array($this->parent[$tag])) {
              $key = count(array_filter(array_keys($this->parent[$tag]), 'is_numeric'));
             } else {
              $key = 0;
             }
            } else {
                if (array_key_exists("$tag attr",$this->parent)) {
                    $arr = array('0 attr'=>&$this->parent["$tag attr"], &$this->parent[$tag]);
                    unset($this->parent["$tag attr"]);
                } else {
                    $arr = array(&$this->parent[$tag]);
                }
                $this->parent[$tag] = &$arr;
                $key = 1;
            }
            $this->parent = &$this->parent[$tag];
        } else {
            $key = $tag;
        }
        if ($attributes) $this->parent["$key attr"] = $attributes;
        $this->parent = &$this->parent[$key];
        $this->stack[] = &$this->parent;
    }
	 
    function data(&$parser, $data) {
        if ($this->last_opened_tag != NULL) {
        	if(function_exists("iconv")){
        		$this->data .= iconv("gbk", 'utf-8', $data);
        	}elseif(function_exists("mb_convert_encoding")){
        		$this->data .= mb_convert_encoding($data, "utf-8", "gbk");
        	}else{
        		$this->data .= utf8_encode($data);
        	}
        }
    }
    function close(&$parser, $tag) {
        if($this->last_opened_tag == $tag){
            $this->parent = $this->data;
            $this->last_opened_tag = NULL;
        }
        array_pop($this->stack);
        if ($this->stack) $this->parent = &$this->stack[count($this->stack)-1];
    }
}
?>