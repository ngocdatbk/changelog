<?php 

	echo \APT::ip()."|".\SQL::getServerIP();
	
	if (Client::$viewer->id==1){
		print_r($_SERVER);
	}
	exit;
	
?>