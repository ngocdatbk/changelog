<?php 

	/**
	 * @desc Issue a new token
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	$appid=HTML::inputInline("id");
	
	$tokens=\Client::$system->data->get("tokens");
	if (!$tokens || !count($tokens)){
		$tokens=[];
	}else{
		$tokens=\ARR::filter($tokens, function($e)use($appid){
			if (isset($e->id) && $e->id==$appid){
				return false;
			}
			
			return true;
		});
	}
	
	
	Client::$system->data->tokens=$tokens;
	
	Client::$system->edit("data");
	
	Ajax::release(Code::success());
	
?>