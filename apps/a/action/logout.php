<?php

	if (Client::$viewer->auth()){
		if (\APT::makeCode()!=HTML::get("token")){
			$url=Client::$viewer->getLogoutURL()."&app=".\HTML::get("app")."&return=".\HTML::get("return");
			echo "<center><a href='$url'>Click here to logout</a></center>"; 
			exit;
		}else{
			Client::$viewer->logout();
			Cookie::clear("__channel");
			Cookie::clear("company_id");
			Cookie::clear("msgchannels");
			Cookie::clear("msgpc");
		}
	}else{
		Client::$viewer->logout();
		
		Cookie::clear("__channel");
		Cookie::clear("company_id");
		Cookie::clear("msgchannels");
		Cookie::clear("msgpc");
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
	
	APT::redirect("a/login?app=".HTML::get("app")."&return=".HTML::get("return"));

?>