<?php 
	$user=User::withUsername(Action::tail(":first"));
	if (!$user || !$user->good()){
		Request::pageError("Cannot find the user");
	}

	layout("mainapp", "~layout.tpl");
	btitle($user->name, "Tài khoản");
	
	$cv=\user\CV::init($user);
	
	if (!$cv){
		Request::pageError("Cannot find the user cv");
	}
	
	
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