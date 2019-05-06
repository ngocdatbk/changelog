<?php 

	$network=Network::withHID(HTML::inputInline("hid"));
	
	if (!$network || !$network->tokenMatched()){
		Ajax::release(Code::INVALID_DATA);
	}

	if ($network->isRoot()){
		Ajax::release("Cannot leave the company network. Only your system admin can revoke your access");
	}
	
	
	if (!Client::$viewer->hasNetwork($network)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	
	if (this\owner($network)){
		// Check count owners
		$count=$network->countRole(Member::OWNER);
		if ($count==1){
			Ajax::release("You are the single owner of the team and cannot leave it. To leave the team, please set someone else as the team's owner first.");
		}
	}
	
	
	$can_leave=$network->getSettings("team", "leave");
	if ($can_leave=="no"){
		Ajax::release("This team does not allow its team members to leave. Please contact the team owners for help.");
	}
	
	// Revoke accesss
	
	SQL::commit();
	if (!$network->revoke(Client::$viewer)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	Client::$viewer->unload();
	Ajax::release(Code::success());
	
?>