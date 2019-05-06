<?php 

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	
	
	// Total usrr vs. user limit
	
	$total=User::count("system_id='".\Client::$system->id."' and status >=0");
	$limit=\Client::$system->getUserLimit();
	
	if ($total>=$limit && ENV==1){
		Ajax::release("We are sorry. The maximal number of allowed user/guest accounts is <b>$limit</b>. Your company <b>".Client::$system->name."</b> current has <b>$total</b> account.");
	}
	

	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}

	if ($user->isGuest()){
// 		$user->password='invalid';
// 		$user->role=-1;
// 		$user->data->email=$user->email;		
		
// 		if (!$user->edit('password, role, email')){
// 			Ajax::release(Code::INVALID_DATA);
// 		}

		Ajax::release("We are sorry. The system currently doesn't support REACTIVATE guest access.");
	}else{
		$user->password='invalid';
		$user->status=1;
		$email=$user->data->get("email");
		if (!$email){
			$email=$user->email;
		}
		
		$user->email=$email;
		if (!\Valid::email($email)){
			Ajax::release("The email is not of valid form.");
		}
		
		if (User::count("email='$email' and id!={$user->id}")){
			Ajax::release("The email {$email} exists in the system. Please try again.");
		}
		
		$user->data->reactivated_since = time();
		
		if (!$user->edit('password, status, email, data')){
			Ajax::release(Code::INVALID_DATA);
		}	
		
		$user->unload();
	}
	
	
	Ajax::extra("user", $user->release());
	Ajax::release(Code::success());
?>