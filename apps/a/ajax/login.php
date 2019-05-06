<?php

	$email=HTML::inputInline("email");
	$password=HTML::inputInline("password");
	
	$appkey = HTML::inputInline("appkey");

	Client::$viewer->email=$email;
	Client::$viewer->password=$password;
	
	if (!Valid::email($email)){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	if (!Valid::password($password)){
		Ajax::release(Code::INVALID_PASSWORD);
	}
	
	
	if (!GA2FA::validateLogin($email)){
		if (!HTML::inputInline("code_2fa")){
			Ajax::release("ERROR_2FA_EMPTY");
		}else{
			Ajax::release("ERROR_2FA_INVALID");
		}
	}
	
	$code=Client::$viewer->login();
	
	if (!$code->good()){
		Ajax::extra("error_code",$code->message);
		Ajax::release("Email and password doesn't match.");
	}
	
	if (HTML::inputCheckbox("saved")){
		Cookie::set("ape", Client::$viewer->email, 10, 'd', true);
		Cookie::set("aps", \User::md5(Client::$viewer->password.Client::$viewer->getAuthKey()), 10, 'd', true);
		Cookie::set("xlogin", 1, 10, 'd', true);
	}else{
		Cookie::clear("ape");
		Cookie::clear("aps");
		Cookie::clear("xlogin");
	}
	
	Cookie::set("user_id", Client::$system->path."_".Client::$viewer->id);
	
	if ($appkey) {
		Ajax::extra("appkey", $appkey);
	}
	
	Ajax::release(Code::success());

?>