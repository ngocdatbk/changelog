<?php
	if (!\this\admin(Client::$system)){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	/*
	$enable = HTML::inputInline("enabletos");
	if (!$enable) {
		// Remove old TOS and disable learning
		Client::$system->data->tosdoc = "";
		Client::$system->edit('data');
		Ajax::release(Code::success("Updated settings successfully."));
	}
	*/
	$code = FileDB::upload("tosdoc", Client::$system);
	
	if ($code->good()){
		FileDB::setTransparency(false);
		$id = $code->message->id();
		
		Client::$system->data->tosdoc = $id;
		Client::$system->edit('data');
		Ajax::release(Code::success("Updated TOS successfully."));
	}else{
		Ajax::release("Please upload TOS document");
	}
	
?>