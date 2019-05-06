<?php 

	if (!\w\company\isAdmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$email=HTML::inputInline("email");
	
	if (!Valid::email($email)){
		Ajax::release("EMAIL.INVALID");
	}
	
	$paths=Word::split("@", $email);
	if (count($paths)!=2){
		Ajax::release("EMAIL.INVALID");
	}
	
	$domain=$paths[1];
	
	if (inset($domain, "gmail.com", "yahoo.com", "live.com")){
		Ajax::release("EMAIL.INVALID");
	}
	

	w\company\testAuthMail($email, $domain);
	
	Ajax::extra("edomain", $domain);
	Ajax::extra("email", $email);
	
	Ajax::release(Code::success());
	
?>