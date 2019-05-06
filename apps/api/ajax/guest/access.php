<?php 

	/**
	 * @desc Edit accesses
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$user=\User::withUsername(HTML::inputInline("username"));
	
	if (!$user || !$user->good() || !$user->isGuest()){
		Ajax::release(Code::INVALID_DATA);
	}

	$accesses=\Word::split(",", HTML::inputInline("accesses"));
	$sm=new \sys\SubManager(\Client::$system);
	
	$accesses=\ARR::filter($accesses, function($e)use($sm){
		if ($sm->enabled($e)){
			return true;
		}
		
		return true;
		
		// return false;
	});
	
	$user->accesses=$accesses;
	$user->edit("accesses");
	
	Ajax::release(Code::success());
	
?>