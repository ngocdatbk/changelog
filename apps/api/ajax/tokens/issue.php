<?php 

	/**
	 * @desc Issue a new token
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	$appkey=HTML::inputInline("appkey");
	
	
	$app=\base\App::withName($appkey);

	if (!$app){
		Ajax::release("Cannot find the app");
	}
	
	
	// Issue new token
	
	$token=(object)[
		"id"=>\Word::random(32),
		"app"=>$appkey,
		"token"=>Client::$system->id."-".\Word::random(32)."-".\Word::random(32),
		"issued_by"=>Client::$viewer->username,
		"since"=>time(),
		"status"=>1
	];
	
	
	$tokens=Client::$system->data->get("tokens");
	if (!$tokens){
		$tokens=[];
	}
	
	$tokens[]=$token;
	
	Client::$system->data->tokens=$tokens;
	
	Client::$system->edit("data");
	
	Ajax::release(Code::success());
?>