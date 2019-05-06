<?php 

	/**
	 * @desc Get system's public team
	 */

	if (!\this\admin(Client::$system)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$teams=Network::find("system_id='".Client::$system->id."'");
	Ajax::extra("teams", release($teams));
	Ajax::release(Code::success());
?>