<?php
	$user=\user\CV::safeInspectUser();

	$cv=user\CV::init($user);
	if (!$cv){
		Ajax::release(Code::INVALID_DATA);
	}

	
	$cv->setLink("homepage", \user\CVReader::readLink("homepage"));
	$cv->setLink("facebook", \user\CVReader::readLink("facebook"));
	$cv->setLink("linkedin", \user\CVReader::readLink("linkedin"));
	$cv->setLink("twitter", \user\CVReader::readLink("twitter"));
	
	if (!$cv->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::release(Code::success());
?>