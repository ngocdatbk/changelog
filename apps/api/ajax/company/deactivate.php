<?php 

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	
	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}

	if ($user->isGuest()){
		$user->password='invalid';
		$user->status=-1;
		$user->data->email=$user->email();
		$user->data->deactivated_since = time();
		
		if (!$user->edit('password, role, status, email, data')){
			Ajax::release(Code::INVALID_DATA);
		}
	}else{
		$user->password='invalid';
		$user->status=-1;
		$user->data->email=$user->email;
		$user->email="removed.".Word::random(16)."@deactivated.".DOMAIN;
		$user->data->deactivated_since = time();
		
		
		if (!$user->edit('password, role, status, email, data')){
			Ajax::release(Code::INVALID_DATA);
		}	
	}
	
	$user->unload();
	
	Ajax::extra("user", $user->release());
	Ajax::release(Code::success());
?>