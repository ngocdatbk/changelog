<?php 

	/**
	 * @desc  Enable two-factor authentication
	 */

	$status=HTML::inputInt("status");
	
	if (!$status){
		$status=0;
	}else{
		$status=1;
	}
	
	if ($status==1){
		if (!Client::$viewer->data->get("tfa_token")){
			Client::$viewer->data->set("tfa_token", \Word::random(32));
		}
		
		Client::$viewer->data->tfa_status=1;
		$ga=new GA2FA(Client::$viewer, Client::$system);
		
		// Checking code
		if (!$ga->verify(HTML::inputInline("verifier"))){
			Ajax::release("The 06-digit code is invalid. Please enter the correct code.");
		}
		
	}else{
		Client::$viewer->data->tfa_status=0;
	}
	
	
	Client::$viewer->edit("data");
	
	Ajax::release(Code::success());
	
?>