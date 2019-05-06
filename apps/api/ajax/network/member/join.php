<?php 

	$network=Network::withHID(HTML::inputInline("hid"));
	
	if (!$network || !$network->tokenMatched()){
		Ajax::release(Code::INVALID_DATA);
	}

	if ($network->isRoot()){
		Ajax::release("Cannot join the company network. You are joined by default.");
	}
	
	if ($network->system_id!=Client::$system->id){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	
	if (Client::$viewer->hasNetwork($network)){
		Ajax::release("You are already a member of this team");
	}
	
	
	SQL::commit();
	if (!$network->addMember(Client::$viewer, Member::REGULAR)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	
	Client::$viewer->unload();
	Ajax::release(Code::success());
	
?>