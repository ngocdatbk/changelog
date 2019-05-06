<?php 

	layout("mainapp", "~tokens.tpl");
	
	Client::pageData("tokens", Client::$system->data->get("tokens"));

?>