<?php 

	if (!Client::$viewer->auth()){
		Ajax::extra("command","LOGIN");
		Request::pageError("You need to login first");
	}
	

	Request::enableCORS("*.".DOMAIN);
?>