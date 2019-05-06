<?php 

	/**
	 * @desc Add a new account
	 */

	if (!\this\sysowner()){
		Ajax::release("Only system owner can create guest account");
	}


	// Total usrr vs. user limit
	
	$total=User::count("system_id='".\Client::$system->id."' and status >=0");
	$limit=\Client::$system->getUserLimit();
	
	if ($total > $limit && ENV != 0) {
		Ajax::release("We are sorry. The maximal number of allowed user/guest accounts is <b>$limit</b>. Your company <b>".Client::$system->name."</b> current has <b>$total</b> account.");
	}


	$name=HTML::inputInline("name");
	$email=HTML::inputInline("email");
	$username=HTML::inputInline("username");
	
	$app=APPKEY;
	
	
	
	// Create a guest account. Guest account is a private account used solely
	
	FileDB::ns("sys".Client::$system->id);
	$user=sys\Guest::create($name, $email, $username, $app);
	
	if ($user){
		Ajax::release(Code::success());
	}
	
	Ajax::release("Cannot create guest account with this email {$email}");

?>