<?php 

	// Get server
	
	if (!Client::initSystem()){
		exit("No system");
	}
	
	if (Client::$viewer->auth() && Client::$viewer->priv==-1){
		exit("The account was temporarily deactivated.");
	}

?>