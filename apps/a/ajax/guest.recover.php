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
	
	
	$access=HTML::inputInline("access");
	$system=\sys\System::single("path='$access'");
	if (!$system){
		\Ajax::release("Please enter your valid access point");
	}
	
	
	if (!Valid::email($email)){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	
	$email=\sys\Guest::hashEmail($email, $system);
	
	$user=User::withEmail($email);
	if (!$user){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	mail\account\recoverGuestPassword($user, $system);
	Ajax::release(Code::success());
?>