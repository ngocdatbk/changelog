<?php
	$dir=dirname(__FILE__);
	require_once($dir."/../init.php");
	define("REQUEST_TYPE","ajax");
	
	
	AP::initAppFullFeatures();
	require_once(AP_ROOT."/www/ajax.php");
?>