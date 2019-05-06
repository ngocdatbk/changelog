<?php 

	/**
	 * @desc Edit special access
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$accesses=\Word::split(",", HTML::inputInline("accesses"));
	
	$user=User::withUsername(HTML::inputInline("username"));
	
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$user->sas=$accesses;
	$user->edit("sas");
	
	Ajax::release(Code::success());

?>