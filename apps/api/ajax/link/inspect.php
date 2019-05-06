<?php 

	$type=HTML::inputInline("type");
	$key=HTML::inputInline("key");
	
	if ($type && $key){
		$obj=getObject($key);
		if (!$obj){
			$obj=recoverObjectByType($type, $key);
		}
		
	
	
		if ($obj && $obj->good()){
			if (!$obj->viewable(Client::$viewer)){
				// Request::pageError("The resource is not viewable by you anymore.");
			}
				
			Ajax::extra("url", $obj->getAbsLink());
			Ajax::release(Code::success());
				
		}
	}
	
	Ajax::release(Code::success());

?>