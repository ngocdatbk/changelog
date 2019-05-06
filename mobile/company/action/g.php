<?php 

	/**
	 * @desc Manage a single group
	 */

	layout("mainapp","~network/layout.tpl");
	$path=Action::tail(":first");
	if (!Valid::username($path)){
		Request::pageError(Code::INVALID_AUTHENTICATION);
	}
	
	$network=Network::single("path='$path' and system_id='".Client::$system->id."'");
	if (!$network){
		Request::pageError(Code::INVALID_AUTHENTICATION);
	}
	
	if (!$network->isOfficial() && !$network->hasMember(Client::$viewer)){
		Request::pageError(Code::INVALID_AUTHENTICATION);
	}
	
	
	$people=$network->getPeople(0);
	
	Client::pageData("people", ARR::select($people, function(&$p){
		$obj=$p->releaseWithRole();
		$obj->ms=$p->member->release();
		return $obj;
	}));
	
	post("g", $network);
	
	Client::pageData("network", $network->release());
	Client::$context=$network;
	
?>