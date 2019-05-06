<?php 

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}

	if (!$user->isGuest()){
// 		$user->password='invalid';
// 		$user->status=-1;
// 		$user->data->email=$user->email;		
		
// 		if (!$user->edit('password, role, email')){
// 			Ajax::release(Code::INVALID_DATA);
// 		}

		Ajax::release("We are sorry. This function is to reactivate guest account only.");
	}else{
		$user->password='invalid';
		$user->status=0;
		// $email=$user->data->get("email");
		
		//if (!$email){
		//	$email=$user->email;
		// }
		// $user->email=$email;
		
		$user->data->reactivated_since = time();
		
		if (!$user->edit('role, status, email, data')){
			Ajax::release(Code::INVALID_DATA);
		}
		
		Ajax::extra("user", $user->release());
		
		$user->unload();
	}
	
	
	Ajax::extra("user", $user->release());
	Ajax::release(Code::success());
?>