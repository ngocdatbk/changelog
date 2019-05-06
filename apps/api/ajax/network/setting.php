<?php 

	$hid=Action::tail(":first");
	$network=Network::withHID($hid);
	
	if (!$network || !$network->good() || $network->system_id!=Client::$system->id){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	if (!\this\admin($network)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	
	$sobj=$network->getSettings("team");
	if (!$sobj){
		Ajax::release("Settings were not found.");
	}
	
	$sobj->listen();
	
	if (Error::existed()){
		Ajax::release(Error::getError());
	}
	
	
	if (!$sobj->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	
	Ajax::extra("settings", $sobj->release());
	Ajax::release(Code::success());
	
?>