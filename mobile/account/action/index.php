<?php

	if (Client::$viewer->isGuest()){
		Action::forward("redirect");
	}

	layout("mainapp", "~layout.tpl");

	btitle(Client::$viewer->name, "Tài khoản");
	
	$cv=\user\CV::init(Client::$viewer);
	
	if (!$cv){
		Request::pageError("Cannot find the user cv");
	}
	
	
	$user=Client::$viewer;
	
	post("user", $user);
	post("cv", $cv);
	
	
	$networks=Network::loadListComplete($user->networks);
	foreach ($networks as $n){
		$n->ms=Member::getObject($n, $user);
	}
	
	post("networks", $networks);
	
	$units=ARR::filter($networks, function($e){
		return ($e->metatype=="unit");
	});
	
	post("units", $units);

	Client::pageData("cv", $cv->data);
	Client::pageData("cvlinks", $cv->links ?:[]);
?>