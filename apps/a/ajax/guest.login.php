<?php

	$email=HTML::inputInline("email");
	$password=HTML::inputInline("password");
	
	$access=HTML::inputInline("access");
	$system=\sys\System::single("path='$access'");
	if (!$system){
		\Ajax::release("Please enter your access point");
	}
	
	$appkey = HTML::inputInline("appkey");

	
	Client::$viewer->email=\sys\Guest::hashEmail($email, $system);
	Client::$viewer->password=$password;
	
	if (!Valid::email($email)){
		Ajax::release(Code::INVALID_EMAIL);
	}
	
	if (!Valid::password($password)){
		Ajax::release(Code::INVALID_PASSWORD);
	}
	
	$code=Client::$viewer->login();
	
	if (!$code->good()){
		Ajax::release("Email and password doesn't match.");
	}
	
	if (HTML::inputCheckbox("saved")){
		Cookie::set("ape", Client::$viewer->email, 10);
		Cookie::set("aps", User::md5(Client::$viewer->password), 10);
		Cookie::set("xlogin", 1, 10);
	}else{
		Cookie::clear("ape");
		Cookie::clear("aps");
		Cookie::clear("xlogin");
	}
	
	if ($appkey) {
		Ajax::extra("appkey", $appkey);
	}
	
	Ajax::release(Code::success());

?>