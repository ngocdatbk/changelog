<?php 
	
	$root=Client::$system->rootNetwork();
	if (!$root || !$root->good()){
		Ajax::release("Invalid Network");
	}

	
	if (!\this\admin($root)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	if (HTML::inputInt("list")){
		$emails=Word::split(array(","," ",";","\n"),HTML::inputRaw("emails"));
		$success=[];
		foreach ($emails as $email){
			if (!Valid::email($email)){
				continue;
			}
			
			$sc=new SQLCond();
			$sc->equal("email", $email);
			if (BIG_SYSTEM){
				$sc->equal("system_id", Client::$system->id);
			}
			
			if (User::single($sc->text())){
				continue;
			}

			\mail\company\invite(Client::$viewer, $email, $email);
			$success[]=$email;
		}
		
		if (!count($success)){
			Ajax::release("No valid email was sent.");
		}
			
		Ajax::extra("emails", $success);
		Ajax::release(Code::success());
	}else{
		
		$email=HTML::inputInline("email");
		$first_name=HTML::inputInline("first_name");
		
		if (!Valid::email($email)){
			Ajax::release("EMAIL.INVALID");
		}
		
		if (!Valid::length($first_name,2,100)){
			Ajax::release("EMAIL.NAME");
		}
		
		$sc=new SQLCond();
		$sc->equal("email", $email);
		if (BIG_SYSTEM){
			$sc->equal("system_id", Client::$system->id);
		}
		
		if (User::single($sc->text())){
			Ajax::release('EMAIL.USED');
		}
		
		\mail\company\invite(Client::$viewer, $email, $email);
	}
	
	
	Ajax::release(Code::success());
	
?>