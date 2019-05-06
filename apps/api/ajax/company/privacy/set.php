<?php 

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$privacy=HTML::inputInline("privacy");
	if ($privacy===false || !inset($privacy,0,1)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	Client::$system->data->privacy=$privacy;
	
	Client::$system->edit("data");
	Ajax::release(Code::success());
	
?>