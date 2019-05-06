<?php 

	/**
	 * @desc Setting IP config
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_DATA);
	}

	$ips=HTML::inputInline("ips");

	$ranges=\Word::split([",", ";"], $ips);
	
	$ranges=\ARR::filter($ranges, function($e){
		return \sec\IP::valid($e);
	});
	
	if (count($ranges)){
		Client::$system->data->set("reqip", 1);
		Client::$system->data->set("ips", \Word::join(",",$ranges));
	}else{
		Client::$system->data->reqip=0;
		Client::$system->data->ips="";
	}
	
	Client::$system->edit("data");
	Ajax::release(Code::success());
	
?>