<?php
/**
 * Description ...
 *
 * PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: file.class.php 462 2009-12-27 03:20:41Z steven $
 */
class Files extends PbObject
{
	var $mFolders = Array();
	var $mFiles = Array();
	var $mDateTime = "Y-m-d H-i-s";
	var $mTimeOffset = 8;
	
	function Files(){
	}

	function __construct(){
		$this->Files();
	}

	function dir_writeable($dir) {
		if(!is_dir($dir)) {
			@mkdir($dir, 0777);
		}
		if(is_dir($dir)) {
			if($fp = @fopen("$dir/pb_sample.txt", 'w')) {
				@fclose($fp);
				@unlink("$dir/pb_sample.txt");
				$writeable = true;
			} else {
				$writeable = false;
			}
		}else{
			return is_writable($dir);
		}
		return $writeable;
	}
	
	function file_writeable($file_name)
	{
		return is_writable($file_name);
	}

	function mkDirs ($dir) {
		$dir = str_replace("\\","/",$dir);
		$dirs = explode('/', $dir);
		$total = count($dirs);
		$temp = '';
		for($i=0; $i<$total; $i++) {
			$temp .= $dirs[$i].'/';
			if (!is_dir($temp)) {
				if (!@mkdir($temp)) return;
				@chmod($temp, 0777);
			}
		}
	}
	
	function rmDirs ($dir, $rmself = false) {
		if(substr($dir,-1)=="/"){
			$dir=substr($dir,0,-1);
		}
		if(!file_exists($dir)||!is_dir($dir)){
			return false;
		} elseif(!is_readable($dir)){
			return false;
		} else {
			$dirs= opendir($dir);
			while (false!==($entry=readdir($dirs))) {
				if ($entry!="."&&$entry!="..") {
					$path=$dir."/".$entry;
					if(is_dir($path)){
						$this->rmDirs($path);
					} else {
						unlink($path);
					}
				}
			}
			//关闭目录
			closedir($dirs);
			if($rmself){
				if(!rmdir($dir)){
					return false;
				}
				return true;
			}
		}
	}
	
	function delFile ($file) {
		if ( !is_file($file) ) return false;
		@unlink($file);
		return true;
	}
	
	function createFile ($file, $content="", $mode="w") {
		if ( in_array($mode, array("w", "a")) ) $mode = "w";
		if ( !$hd = fopen($file, $mode) ) return false;
		if ( !false === fwrite($hd, $content) ) return false;
		return true;
	}
	
	function getFolders ($dir) {
		$this->mFolders = Array();
		if(substr($dir,-1)=="/"){
			$dir=substr($dir,0,-1);
		}
		if(!file_exists($dir)||!is_dir($dir)){
			return false;
		}
		$dirs= opendir($dir);
		$i = 0;
		while (false!==($entry=readdir($dirs))) {
			if ($entry!="."&&$entry!="..") {
				$path=$dir."/".$entry;
				if(is_dir($path)){
					$filetime = @filemtime($path);
					$filetime = @date($this->mDateTime, $filetime+3600*$this->mTimeOffset);
					$this->mFolders[$i]['name'] = $entry;
					$this->mFolders[$i]['filetime'] = $filetime;
					$this->mFolders[$i]['filesize'] = 0;
					$i++;
				}
			}
		}
		return $this->mFolders;
	}
	
	function getFiles ($dir) {
		$this->mFiles = Array();
		if(substr($dir,-1)=="/"){
			$dir=substr($dir,0,-1);
		}
		if(!file_exists($dir)||!is_dir($dir)){
			return false;
		}
		$dirs= opendir($dir);
		$i = 0;
		while (false!==($entry=readdir($dirs))) {
			if ($entry!="."&&$entry!="..") {
				$path=$dir."/".$entry;
				if(is_file($path)){
					$filetime = @filemtime($path);
					$filetime = @date($this->mDateTime, $filetime+3600*$this->mTimeOffset);
					$filesize = $this->getFileSize($path);
					$this->mFiles[$i]['name'] = $entry;
					$this->mFiles[$i]['filetime'] = $filetime;
					$this->mFiles[$i]['filesize'] = $filesize;
					$i++;
				}
			}
		}
		return $this->mFiles;
	}
	
	function getFileSize ($file) {
		if ( !is_file($file) ) return 0;
		$f1 = $f2 = "";
		$filesize = @filesize("$file");
		if ( $filesize > 1073741824 ) {
		} elseif ( $filesize > 1048576 ) {
			$filesize = $filesize / 1048576;
			list($f1, $f2) = explode(".",$filesize);
			$filesize = $f1.".".substr($f2, 0, 2)."MB";
		} elseif ( $filesize > 1024 ) {
			$filesize = $filesize / 1024;
			list($f1, $f2) = explode(".",$filesize);
			$filesize = $f1.".".substr($f2, 0, 2)."KB";
		} else {
			$filesize = $filesize."字节";
		}
		return $filesize;
	}
}
?>