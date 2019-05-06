<?php 


	$ga=new GA2FA(Client::$viewer, Client::$system);
	if ($ga->enabled()){
		$url=$ga->getQR();
		post("qr", $url);
	}else{
		$url=$ga->getQR();
		post("qr", $url);
	}
	
	layout("mainapp", "~layout.tpl");

?>