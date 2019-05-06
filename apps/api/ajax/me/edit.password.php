<?php

	$password=HTML::inputInline("password");
	$new_password=HTML::inputInline("new_password");
	$new_password2=HTML::inputInline("new_password2");
	
	if (!Valid::password($new_password)){
		Ajax::release("INVALID.PASSWORD");
	}
	
	if ($new_password!=$new_password2){
		Ajax::release("PASSWORD.MISMATCH");
	}
	
	if (User::md5($password)!=Client::$viewer->password && !Client::$viewer->passwordVerify($password)){
		Ajax::release("WRONG.OLD.PASSWORD");
	}
	
	
	$force_logout=HTML::inputInt("force_logout");
	
	Client::$viewer->password=Client::$viewer->passwordHash($new_password);
	
	if ($force_logout){
		Client::$viewer->data->authkey=\Word::random(64);
		Client::$viewer->devices=[];
		
		// Remove all authentication tokens for this user
		
		if (!Client::$viewer->edit('password, data, devices')){
			Ajax::release(Code::DB_ERROR);
		}
		
		\oauth\SimpleClient::revokeAll(Client::$viewer->id);
	}else{
		if (!Client::$viewer->edit('password')){
			Ajax::release(Code::DB_ERROR);
		}
	}
	
	
	\w\user\notifyPasswordChanged();
	
	if ($force_logout){
		Client::$viewer->logout();
	}
	
	Ajax::release(Code::success());
?>