<?php 

	/**
	 * @desc Create a new office
	 */

	SQL::commit();
	$network=Network::withHID(HTML::inputInline("hid"));
	
	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	if (!$network->tokenMatched()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	

	if ($network->isRoot()){
		Ajax::release("Cannot close the company network.");
	}else{
		$network->status=0;
	}
	
	
	if (!$network->edit('status')){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
		
	$network->unload();
	Ajax::extra("network", $network->export());
	Ajax::release(Code::success());
?>