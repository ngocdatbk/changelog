<?php 

	$user=\user\CV::safeInspectUser();

	$cv=user\CV::init($user);
	if (!$cv){
		Ajax::release(Code::INVALID_DATA);
	}

	$row=null;
	$type=HTML::inputInline("type");
	
	if ($type=="education"){
		$row=\user\CV::read([
			"name"=>"string*",
			"major"=>"string*",
			"time"=>"string*",
		]);
	}elseif ($type=="work"){
		$row=\user\CV::read([
			"name"=>"string*",
			"position"=>"string*",
			"time"=>"string*",
			"desc"=>"text"
		]);
	}elseif ($type=="award"){
		$row=\user\CV::read([
			"name"=>"string*",
			"time"=>"string*",
			"desc"=>"text"
		]);
	}else{
		Ajax::release(Code::INVALID_DATA);
	}
	
	if (!$row){
		Ajax::release("Please enter all required fields");
	}
	
	
	$cv->add($type, $row);
	
	if (!$cv->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::release(Code::success());

?>