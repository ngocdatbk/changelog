<?php 

	$hid=Action::tail(":first");
	$system=Client::$system;
	if ($system->hid()!=$hid){
		Ajax::release(Code::INVALID_DATA);
	}

	if (!\this\owner($system)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	
	$sobj=$system->getSettings("system");
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