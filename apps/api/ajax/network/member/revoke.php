<?php 

	$network=new Network(HTML::inputInt(("network")));
	
	if (!$network || !$network->tokenMatched() || $network->isRoot()){
		Ajax::release("CANNOT REMOVE MEMBER FROM THE COMPANY. YOU CAN ONLY DEACTIVATE THIS ACCOUNT");
	}

	
	if (!this\owner($network) && !\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	if ($network->isRoot()){
		Ajax::release("Cannot remove the member from the company network. But you can deactive this account.");
	}
	
	$user=User::withUsername(HTML::inputInline(("username")));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	if (!$user->hasNetwork($network)) {
		$member = Member::getObject($network, $user);
		if (!$member) {
			Ajax::release("The user is not a member of this group");
		}
	}
	
	// Revoke accesss
	
	SQL::commit();
	if (!$network->revoke($user)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	
	Ajax::release(Code::success());
	
?>