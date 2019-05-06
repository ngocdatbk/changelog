<?php 

	/**
	 * @desc Disable 2fa authentication of a particular user
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}

	$user->data->tfa_status=0;
	
	$user->edit("data");
	Ajax::release(Code::success());
	
?>