<?php
/**
 * Note : The Software shall be used for Good, not Evil.
 * PHPB2B - As an open source b2b program.
 *
 * Permission is hereby granted to use this version of the library under the
 * following license:
 *
 * --
 * Copyright (c) 2006-2009 PHPB2B (http://www.phpb2b.com/)
 *
 * All rights granted under this License are granted for the term of copyright on
 * the Program, and are irrevocable provided the stated conditions are met. This
 * License explicitly affirms your unlimited permission to run the unmodified Program.
 * The output from running a covered work is covered by this License only if the
 * output, given its content, constitutes a covered work.
 * This License acknowledges your rights of fair use or other equivalent, as provided
 * by copyright law.
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * --
 *
 * @package phpb2b
 * @subpackage libraries
 * @copyright 2009 PHPB2B <phpb2b@hotmail.com> (http://www.phpb2b.com/)
 * @license http://www.opensource.org/licenses/gpl-license.php GPL License
 * @created 2009-8-28 9:45
 * @link http://sourceforge.net/projects/php-b2b/
 * @version $Id$
 */
class PbView extends PbObject
{
	var $theme_path = "default";
	var $theme_url = "default/";
	var $homepage_name = "index.php";
	var $titles = array();
	var $pageTitle = null;
	//var $breads = array();
	var $here = null;
	var $position = array();


	function PbView(){
	}

	function __construct(){
		$this->PbView();
	}

    function setTitle($title)
    {
    	$this->titles[] = $title;
    }

    function getTitle($seperate = " &laquo; ")
    {
        $title = array();
        $pageTitle = null;
    	$title = $this->titles;
    	krsort($title);
    	$pageTitle = implode($seperate, $title);
    	$this->pageTitle = $pageTitle;
    	return $pageTitle;
    }

    /**
     * bread org
     *
     * @param unknown_type $breads
     * @return unknown
     */
    function setPosition2($positions, $seperate = " &gt; ")
    {
    	$position = array();
        uasort($positions, "bread_compare");
        foreach ($positions as $key=>$val){
            if(!empty($val['url'])) {
                if(isset($val['params'])) $position[] = "<a href='".$val['url'].queryString($val['params'])."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
                else $position[] = "<a href='".$val['url']."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
            }else {
                $position[] = $val['title'];
            }
        }
        $this->here = implode($seperate, $position);
    }

    function setPosition($title, $url = null, $displayorder = 0, $additonalParams = array())
    {
        $this->position[] = array('displayorder'=>$displayorder, 'title'=>$title, 'url'=>$url, 'params'=>$additonalParams);
    }

    function getPosition($seperate = " &gt; ")
    {
    	$position = array();
    	$current_position = null;
    	$positions = $this->position;
        uasort($positions, "bread_compare");
        foreach ($positions as $key=>$val){
            if(!empty($val['url'])) {
                if(isset($val['params'])) $position[] = "<a href='".$val['url'].queryString($val['params'])."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
                else $position[] = "<a href='".$val['url']."' target='_self' title='".$val['title']."'>".$val['title']."</a>";
            }else {
                $position[] = $val['title'];
            }
        }
        $current_position = L("your_current_position", "tpl").implode($seperate, $position);
        $this->here = $current_position;
        return $current_position;
    }
}
?>