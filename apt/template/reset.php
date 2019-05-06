<?php


	Template::html("empty.tpl");
		
	AP::load("apt/template/autobind.php");
	AP::load("apt/template/autodata.php");

	
	Template::resetFunction("reset_page");
	Template::updateFunction("update_page");
 
?>