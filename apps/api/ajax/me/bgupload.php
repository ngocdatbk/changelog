<?php 

	$code=FileDB::upload("file", Client::$viewer, FileDB::IMAGE_TYPES);
	
	if ($code->good()){
		FileDB::setTransparency(false);
		$id=$code->message->id();
		if (!Client::$viewer->data->get("bg") || !count(Client::$viewer->data->get("bg")) || !is_array(Client::$viewer->data->get("bg"))){
			Client::$viewer->data->bg=[];
		}
		
		Client::$viewer->data->bg[]=$id;
		if (count(Client::$viewer->data->bg)>=5){
			Client::$viewer->data->bg=ARR::shift(Client::$viewer->data->bg);
		}
		
		Client::$viewer->edit('data');
	}
	
	
	Ajax::release(Code::success("Update profile successfully"));
?>