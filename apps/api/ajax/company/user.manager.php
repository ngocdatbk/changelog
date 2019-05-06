<?php 

	/**
	 * @desc Set direct manager
	 */


	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$user= User::withUsername(HTML::inputInline("username"));
	
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	$managers=UserList::extract("manager");
	$managers->remove([$user]);
	$user->manager=$managers->usernames();
	$user->edit("manager");
	$user->unload();
	
	Ajax::release(Code::success());
?>