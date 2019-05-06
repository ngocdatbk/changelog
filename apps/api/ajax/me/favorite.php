<?php 


	if (HTML::inputInt("object")){
		$fs=Client::$viewer->data->get("fs");
		if (!$fs){
			$fs=[];
		}
		
		$obj=getObject(HTML::inputInline("hid"));
		if (!$obj || !$obj->good() || !$obj->is('Resource') || !$obj->tokenMatched() || !$obj->nsLocal() || !$obj->viewable(Client::$viewer)){
			Ajax::release(Code::INVALID_AUTHENTICATION);
		}
		
		
		if (ARR::contain($fs, $obj->hid())){
			$fs=ARR::remove($fs, $obj->hid());
			Ajax::extra("added", -1);
		}else{
			$fs[]=$obj->hid();
			Ajax::extra("added", 1);
		}
		
		
	}else{
		$network=new Network(HTML::inputInt("id"));
		
		if (!$network || !$network->good()){
			return Ajax::release(Code::INVALID_DATA);
		}
		
		if (!$network->hasMember(Client::$viewer)){
			return Ajax::release(Code::INVALID_DATA);
		}
		
		$fs=Client::$viewer->data->get("fs");
		if (!$fs){
			$fs=[];
		}
		
		if (HTML::inputInt("remove")){
			$fs=ARR::remove($fs, $network->id);
			$fs=ARR::unique($fs);
			Ajax::extra("added", -1);
		}else{
			$fs[]=$network->id;
			$fs=ARR::unique($fs);
			$fs=ARR::cut($fs, 20);
			Ajax::extra("added", 1);
		}
	}
		
	
	Client::$viewer->data->fs=$fs;
	Client::$viewer->edit('data');
	
	Ajax::extra("favors", Client::$viewer->releaseFavorites());
	Ajax::release(Code::success());
?>