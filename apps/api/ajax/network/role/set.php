<?php

	if (HTML::inputInline('network')){
		$network= new Network(HTML::inputInline('network'));
		if (!$network || !$network->good()){
			$network= Network::withHID(HTML::inputInline('network'));
		}
	}else{
		$network=Client::$system->rootNetwork();
	}
	
	if (!$network || !$network->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if ($network->isRoot()){
		// Ajax::release("Cannot change the membership of head office");
	}
	
	
	if (!this\owner($network) && !this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	

	$user=User::withUsername(HTML::inputInline('username'));
	if (!$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if ($user->isGuest()){
		Ajax::release("CANNOT EDIT GUEST PRIVILEGE");
	}
	
	if ($user->id == Client::$viewer->id) {
		Ajax::extra("user", $user->releaseWithRole());
		Ajax::release(Code::success());
	}
	
	$role=HTML::inputInline("role");
	
	
	if (!inset($role,"admin","owner","member")){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	$member = Member::getObject($network, $user);
	$current_role = $member->role;
	
	
	$rv=Member::REGULAR;
	
	if ($role=="admin"){
		$rv=Member::ADMIN;
	}elseif ($role=="owner"){
		$rv=Member::OWNER;
	}
	
	if (!$network->updateRole($user, $rv)){
		Ajax::release(Code::DB_ERROR);
	}
	
	
	if ($network->isRoot()){
		$user->role=$rv;
		if (!$user->edit("role")){
			Ajax::release(Code::DB_ERROR);
		}
		
		$user->unload();
	}
	
	
	if ($member->role != $current_role) {
		mail\network\push($user->email, $network, "You've set as an $role","
			<p>Dear <b>{$user->name}</b>,</p>
			<p>You've granted an access privilege in <b>{$network->name}</b> by <b>".Client::$viewer->name."</b>.</p>
			<p>Your current privilege @ {$network->name}</b> is <b>".strtoupper($role)."</b>.</p>
		");
		
		N::create($network->hid())
		->type("network:role")
		->title("<b>".Client::$viewer->name."</b> set you as <b>".$role."</b> of <b>{$network->name}</b>.")
		->image(User::avatar(Client::$viewer->username))
		->link($network->link())
		->data($network->export())
		->to($user)
		->except(Client::$viewer)
		->notify()
		->notifyMobiles()
		->save();
	}
	
	
	
	$user->member=$member;
	Ajax::extra("user", $user->releaseWithRole());
	
	Ajax::release(Code::success());
?>