<?php 

	/**
	 * @desc Recover password
	 * The user submits his email and captcha code, the application will send a link to the user's email
	 * so that he can use this link to get a new password.
	 */

	if (!Captcha::check()){
		Ajax::release(Code::INVALID_CAPTCHA);
	}

	$email=HTML::inputSafe("email");
	if (!Valid::email($email)){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	$user=User::withEmail($email);
	if (!$user){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	
	mail\account\recoverPassword($user);
	Ajax::release(Code::success());
?>