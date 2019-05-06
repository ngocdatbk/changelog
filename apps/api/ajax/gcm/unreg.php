<?php

	/**
	 * @desc Register Google cloud messages
	 */

	if (!GCM::unregister()){
		Ajax::release(Code::INVALID_DATA);
	}

	Ajax::extra("devices", Client::$viewer->data->get('devices'));
	Ajax::release(Code::success());

?>