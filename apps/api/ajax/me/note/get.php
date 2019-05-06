<?php 
	$objs=\note\Collection::collect(Client::$viewer); 

	Ajax::extra("notes", ARR::select($objs, function(&$obj){
		return $obj->release();
	}));

	Ajax::release(Code::success());
?>