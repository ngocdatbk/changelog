<?php 

	if (Client::$viewer->isGuest()){
		Action::forward("redirect");
	}


	layout("mainapp", "~layout.tpl");
	btitle(Client::$viewer->name, "Product");
	
?>