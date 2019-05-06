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
	
	
	$people=$network->getPeople(0, false);
	
	Client::pageData("people", ARR::select($people, function(&$p){
		$obj=$p->releaseWithRole();
		$obj->ms=$p->member->release();
		$obj->role=$p->role;
		return $obj;
	}));
	
	
	if ($network->num_people!=count($people)){
		$network->num_people=count($people);
		$network->edit("num_people");
		$network->unload();
	}
	
	post("g", $network);
	
	Client::pageData("network", $network->release());
	
?>