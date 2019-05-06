<?php

	/**
	 * @desc Register Google cloud messages
	 */

	Log::save(json_encode($_POST), "gcm.txt");
	

	if (!GCM::register()){
		Ajax::release(Code::INVALID_DATA);
	}

	Ajax::extra("devices", Client::$viewer->data->get('devices'));
	Ajax::release(Code::success());

?>