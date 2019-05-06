<?php 


	$name=HTML::inputInline("name");
	$email=HTML::inputInline("email");

	if (Word::isEmpty($name)){
		Ajax::release("Please enter the system name");
	}
	
	if (!Valid::email($email)){
		Ajax::release("Please enter a valid administrator email");
	}

	
	\mail\company\inviteSystem(Client::$viewer, $email, $name);
	Ajax::release(Code::success());
?>