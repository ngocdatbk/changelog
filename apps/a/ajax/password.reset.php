<?php 

	/**
	 * @desc Recover password
	 * The user submits his email and captcha code, the application will send a link to the user's email
	 * so that he can use this link to get a new password.
	 */
	
	SQL::commit();

	if (!Captcha::check()){
		Ajax::release(Code::INVALID_CAPTCHA);
	}

	$email=HTML::inputSafe("email");
	$email=str_replace(" ","+",$email);
	
	if (!Valid::email($email)){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	$user=User::withEmail($email);
	if (!$user){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	
	$state=HTML::inputInline("state");
	$time=HTML::inputInline("time");
	$token=HTML::inputInline("token");
	
	
	if (!Valid::int($time) || !$state || !$token){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if ($token!=APT::secureHash($email, $state, $time)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	if ($time > time() || $time<time()-24*3600){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	$password=HTML::inputInline("password");
	
	if (!Valid::password($password)){
		Ajax::release(Code::INVALID_PASSWORD);
	}
	
	if (!$user->resetPassword($password)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	
	// Send email to confirm
	
	mail\account\confirmNewPassword($user);
	Client::$viewer->loginAs($user);
	Ajax::release(Code::success());
?>