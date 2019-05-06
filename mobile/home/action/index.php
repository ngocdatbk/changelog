<?php

	if (!Client::$viewer->auth()){
		Action::forward("a/login");
	}
	
	APT::redirect("account");
	
?>