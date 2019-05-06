<?php 

	/**
	 * @desc Set user password
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if ($user->isGuest()){
		Ajax::release("Cannot change email of a guest account");
	}
	
	if ($user->deactivated()){
		Ajax::release("Cannot change email of a deactivated account");
	}

	$email=HTML::inputInline("email");
	
	if (!\Valid::email($email)){
		Ajax::release("The email is invalid");
	}
	
	if (User::single("email='$email'")){
		Ajax::release("Error: the new email exists in the system.");
	}
	
	
	$user->email=$email;
	$user->data->email=$email;
	$user->edit("email");
	$user->unload();
	
	Ajax::release(Code::success());
	
	
?>