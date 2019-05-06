<?php 

	// Get info

	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}

	Ajax::extra("user",$user->release());
	Ajax::release(Code::success());
	
?>