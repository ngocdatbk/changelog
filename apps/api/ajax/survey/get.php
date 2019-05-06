<?php 

	$hid=HTML::inputInline("hid");
	$token=HTML::inputInline("token");
	
	/**
	 * @var \survey\Survey $obj
	 */
	$obj=getObject($hid);
	
	if (!$obj){
		Ajax::release(Code::INVALID_DATA);
	}

	if (!$obj->is('survey\Survey') || !$obj->tokenMatched()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if (!$obj->viewable(Client::$viewer)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	Ajax::extra("survey", $obj->release());
	
	Ajax::release(Code::success());
?>