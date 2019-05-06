<?php 

	/**
	 * @desc Setting IP config
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$unit=new Unit(HTML::inputInline("id"));
	if (!$unit || !$unit->good() || !$unit->sysLocal()){
		Ajax::release(Code::INVALID_DATA);
	}

	$ips=HTML::inputInline("ips");
	
	$ranges=\Word::split([",", ";"], $ips);
	
	$ranges=\ARR::filter($ranges, function($e){
		return \sec\IP::valid($e);
	});
	
	
	$users=$unit->getUsers(500, false);
	
	foreach ($users as $user){
		if (count($ranges)){
			$user->data->set("reqip", 1);
			$user->data->set("ips", \Word::join(",",$ranges));
		}else{
			$user->data->reqip=0;
			$user->data->ips="";
		}
	
		$user->edit("data");
	}
	
	Ajax::release(Code::success());
	
?>