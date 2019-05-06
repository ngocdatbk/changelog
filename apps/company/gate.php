<?php 

	btitle("People and teams");
	
	if (Client::$viewer->isGuest()){
		Action::forward("redirect");
	}

?>