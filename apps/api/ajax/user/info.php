<?php 

	/**
	 * @desc Get user info
	 */

	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$username=HTML::inputInline("id");
	if (!$username){
		$username=HTML::inputInline("username");
	}

	$user=User::withUsername($username);
	
	if (!$user){
		Ajax::release(Code::INVALID_DATA);
	}
	
	Ajax::extra("user", $user->releaseFull());
	Ajax::release(Code::success());
?>