<?php

	if (!Ajax::$client){
		return;
	}

	Ajax::extra("devices", Client::$viewer->data->get("devices"));
	
	Ajax::release(Code::success());
?>