<?php

	$obj=\survey\Poll::withHID(HTML::inputInline("hid"));
	
	if (!$obj || !$obj->good() || !$obj->tokenMatched()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	if ($obj->user_id!=Client::$viewer->id){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	
	$name=HTML::inputInline("name");
	if (Word::isEmpty($name)){
		Ajax::release("The poll name is empty.");
	}
	
	$obj->name=$name;
	
	
	// Advanced
	$expiredCheck = \HTML::inputInline("expcheck");
	$code=\FileDB::upload("image", $obj, \FileDB::IMAGE_TYPES);
	
	if ($expiredCheck){
		// Calculate expired time
		$expdate = \HTML::inputInline("expired-date");
		$exptime = \HTML::inputInline("expired-time");
			
		$format = 'H:i - l, F d, Y';
		$expStr = $exptime." - ".$expdate;
		$expDateTime = \DateTime::createFromFormat($format, $expStr);
		$expiredTime = $expDateTime->getTimeStamp();
		$obj->data->expired = $expiredTime;
	} else {
		$obj->data->expired = 0;
	}
		
	if ($code && $code->good()){
		$obj->data->cover=$code->message->id();
	}
	
	if (!$obj->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::extra("poll", $obj->release());
	Ajax::release(Code::success());
?>