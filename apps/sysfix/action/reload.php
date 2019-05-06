<?php 

	User::dbloop(function($u){
		$u->unload();
	});

	exit;
?>