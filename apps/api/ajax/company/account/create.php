<?php

	/**
	 * @desc Create a new account in Base
	 */

	
	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	
	// Total usrr vs. user limit
	
	$total=User::count("system_id='".\Client::$system->id."' and status >=0");
	$limit=\Client::$system->getUserLimit();
	
	if ($total>=$limit && ENV==1){
		Ajax::release("We are sorry. The maximal number of allowed user/guest accounts is <b>$limit</b>. Your company <b>".Client::$system->name."</b> current has <b>$total</b> account.");
	}
	
	
	$system=\Client::$system;
	FileDB::ns("sys".Client::$system->id);
	
	$password=Word::random(10);
	$user=new User();
	$user->system_id=$system->id;
	
	$name=HTML::inputInline("name");
	$priv=HTML::inputInline("priv");
	
	$role=1;
	if ($priv=="admin"){
		$role=Member::ADMIN;
	}elseif ($priv=="owner"){
		$role=Member::OWNER;
	}
	
	
	// Admin cannot set privilege
	if (!\this\sysowner()){
		$role=Member::REGULAR;
	}
	
	
	if ($name){
		list($first_name, $last_name)=\Word::extractVietnamesename($name);
		$user->first_name=$first_name;
		$user->last_name=$last_name;
	}else{
		$user->first_name=HTML::inputInline("first_name");
		$user->last_name=HTML::inputInline("last_name");
	}
	
	
	$user->email=HTML::inputInline("email");
	$user->username=HTML::inputInline("username");
	$user->role=$role;
	
	$user->title=HTML::inputInline("title");
	
	
	if (Word::isEmpty($user->first_name)){
		Ajax::release("The first name is empty");
	}
	
	if (Word::isEmpty($user->last_name)){
		Ajax::release("The last name is empty");
	}
	
	if (Word::isEmpty($user->username)){
		Ajax::release("The user is empty");
	}
	
	
	if (!Valid::usernameStrict($user->username)){
		Ajax::release("The username is not valid");
	}
	
	if (Network::reservedKeyword($user->username)){
		Ajax::release("The username is a reserved name. Please use another username.");
	}
	
	if ($user->exist('username, system_id') || Network::count("path='{$user->username}' and system_id='{$system->id}'")){
		Ajax::release("The username is existed before (for another user or team). Please use another username.");
	}

	if ($user->exist('username, system_id')){
		Ajax::release("The username is existed before (for another user). Please use another username.");
	}
	
	
	if (!Valid::email($user->email)){
		Ajax::release("The email is empty or invalid.");
	}
	
	if ($user->exist('email')){
		Ajax::release("The email is existed before in your company. The account is NOT yet created.");
	}
	
	$user->password=$password;

	$code=$user->register();
	$user->password=$user->passwordHash($password);
	$user->edit("password");
	
	if (!$code->good()){
		SQL::markError();
		Ajax::release($code);
	}
	
	
	$root=Client::$system->rootNetwork();
	
	if (!Client::$system->addMember($user, $root, $role)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	if (!Client::$system->createUserNetwork($user)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	
	// Create a sample image
	
	
	Event::pushSystem("system.user.new", Client::$system, $user->release());
	\mail\account\create($user, $password, HTML::inputInline("app"));
	
	Ajax::extra("user", $user->release());
	Ajax::release(Code::success());
?>