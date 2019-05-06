<?php
	if (!Client::$viewer->auth()){
		Action::forward("a/login");
	}

	Action::forward("account");
?>