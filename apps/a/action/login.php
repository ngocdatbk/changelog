<?php 

	layout("main","~login.tpl");
	btitle("Login");
	
	if (base\Server::privateCloud()){
		$sso=\base\Server::sso();
		if ($sso){
			APT::redirect(\base\Base::domain($sso->domain)."/".$sso->redirect);
		}
	}
	
	if (Client::$viewer->auth()){
		APT::redirect("a/logout?app=".HTML::get("app")."&return=".HTML::get("return"));
	}
?>