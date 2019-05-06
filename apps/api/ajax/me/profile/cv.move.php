<?php 

	$cv=user\CV::init(Client::$viewer);
	if (!$cv){
		Ajax::release(Code::INVALID_DATA);
	}

	$type=HTML::inputInline("type");
	$id=HTML::inputInline("id");
	$dir=HTML::inputInline("dir");
	
	if (!inset($type,"education", "work", "award")){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$cv->move($type, $id, $dir);
	if (!$cv->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::release(Code::success());
	
?>