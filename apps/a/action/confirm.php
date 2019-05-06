<?php 

	$s=HTML::get("s");
	$e=HTML::get("e");
	
	APT::redirect(MANAGE_URL."/a/confirm?s={$s}&e={$e}");
	exit;

?>