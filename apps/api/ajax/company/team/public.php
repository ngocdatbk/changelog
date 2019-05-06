<?php 

	/**
	 * @desc Get system's public team
	 */

	$teams=Network::find("system_id='".Client::$system->id."' and type='".Network::TYPE_PUBLIC."'");
	$teams=ARR::filter($teams, function($e){
		if ($e->status==-1){
			return false;
		}
		
		return true;
	});
	
	Ajax::extra("teams", release($teams));
	Ajax::release(Code::success());
?>