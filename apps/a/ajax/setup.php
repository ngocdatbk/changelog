<?php


	$count=\sys\System::count("");
	
	if ($count){
		Ajax::release("Cannot setup. The system is not empty.");
	}

	/**
	 * @desc Create company
	 */

	$sys=HTML::inputInt("sys");
	$token=HTML::inputInline("token");
	$email=HTML::inputInline("email");
	$time=HTML::inputInline("time");
	$invited=HTML::inputInt("invited");
	$user_original_id=HTML::inputInt("user_original_id");
	
	if (!\Valid::email($email)){
		Ajax::release("EMAIL.INVALID");
	}
	
	if (APT::secureHash($email, $time)!=$token){
		// Ajax::release("TOKEN.INVALID 3");
	}
	
	
	SQL::commit();

	list($first_name, $last_name)=Word::extractVietnameseName(HTML::inputInline("name"));
	
	// Checking company
	
	$system=new sys\System();
	$system->name=HTML::inputInline("company");
	$system->path=HTML::inputInline("path");
	
	if (!Valid::length($system->name,3,200)){
		Ajax::release("COMPANY.NAME.INVALID");
	}
	
	
	if (!Valid::subdomain($system->path)){
		Ajax::release("COMPANY.DOMAIN.INVALID");
	}
	
	if (!$system->unique('path')){
		Ajax::release("COMPANY.DOMAIN.DUPLICATED");
	}
	
	if (Network::reservedKeyword($system->path)){
		Ajax::release("YOU CANNOT USE THIS PATH (".$system->path.").");
	}
	
	
	// Checking user
	

	$user=new User();
	$user->password=HTML::inputInline("password");
	$user->email=$email;
	
	if (!Valid::password($user->password)){
		Ajax::release("USER.PASSWORD.INVALID");
	}

	
	
	$user->username=strtolower(HTML::inputInline("username"));
	$user->first_name=$first_name;
	$user->last_name=$last_name;
	
	if (!Valid::username($user->username)){
		Ajax::release("USER.USERNAME.INVALID");
	}

	if (!Valid::length($user->first_name,1,100)){
		Ajax::release("USER.FNAME.INVALID");
	}
	
	if (!Valid::length($user->last_name,1,100)){
		Ajax::release("USER.LNAME.INVALID");
	}
	
	
	// Try to create a new company
	
	if (!$system->save()){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	FileDB::ns("sys".$system->id);
	
	if (!$user->register(true)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	
	if (!$system->setCreator($user)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	if (!$system->createRootNetwork()){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}

	
	Client::$viewer->loginAs($user);

	Ajax::extra("system", $system->release());
	Ajax::release(Code::success());
	

?>