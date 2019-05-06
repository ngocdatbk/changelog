<?php

	\Client::$system = new \sys\System(HTML::inputInline("sys"));

	if (!\Client::$system->good()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
		
   FileDB::ns("sys".Client::$system->id);
	
	
	$token=HTML::inputInline("token");
	$email=HTML::inputInline("email");
	$time=HTML::inputInline("time");
	
	if (!\Valid::email($email)){
		Ajax::release("EMAIL.INVALID");
	}
	
	if (APT::secureHash($email, $time, \Client::$system->token)!=$token){
		Ajax::release("TOKEN.INVALID");
	}
	
	SQL::commit();
	
	
	// Checking user
	
	$check=User::withEmail($email);
	
	if ($check){
		Ajax::release("USER.EMAIL.DUPLICATED");
	}
	
	
	
	$user=new User();
	$user->system_id=Client::$system->id;
	
	if ($check){
		$user->extendObj($check, "email, password");
	}else{
		$user->email=$email;
		$password=HTML::inputInline("password");
		if (!Valid::password($password)){
			Ajax::release("USER.PASSWORD.INVALID");
		}
		$user->password = User::md5($password);
	}
	
	
	$user->first_name=HTML::inputInline("first_name");
	$user->last_name=HTML::inputInline("last_name");
	$user->username=HTML::inputInline("username");
	
	
	if (!Valid::username($user->username)){
		Ajax::release("USER.USERNAME.INVALID");
	}
	
	if (strpos($user->username,".")!==false){
		Ajax::release("Username cannot have dot character.");
	}
	
	
	if (!Valid::length($user->first_name,1,100)){
		Ajax::release("USER.FNAME.INVALID");
	}
	
	if (!Valid::length($user->last_name,1,100)){
		Ajax::release("USER.LNAME.INVALID");
	}
	
	
	if ($user->exist('username, system_id')){
		Ajax::release("USERNAME.DUPLICATED");
	}
	
	$code=$user->register();

	
	if (!$code->good()){
		SQL::markError();
		Ajax::release($code);
	}
	
	$root=Client::$system->rootNetwork();
	
	if (!Client::$system->addMember($user, $root, \Member::REGULAR)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	if (!Client::$system->createUserNetwork($user)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	

	User::loginAs($user);
	Ajax::release(Code::success());
?>