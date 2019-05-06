<?php

	if (Client::$viewer->auth()){
		if (\APT::makeCode()!=HTML::get("token")){
			$url=Client::$viewer->getLogoutURL();
			echo "<center><a href='$url'>Click here to logout</a></center>"; 
			exit;
		}else{
			Client::$viewer->logout();
		}
	}else{
		Client::$viewer->logout();
	}
	
	if (input("r")){
		APT::redirect(input("r"));
		return;
	}
	
	$t=input("t");
	if ($t){
		$url=APT::urlDecode($t);
		if ($url){
			APT::redirect($url);
			return;
		}
	}
	
	APT::redirect("a/login");

?>