<?php 

	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_DATA);
	}

	FileDB::setTransparency(true);
	FileDB::setSize(1, 190, FileDB::RELATIVE_SIZE);
	
	$code=FileDB::upload("file", Client::$system);
	if (!$code || !$code->good()){
		Ajax::release("No file is uploaded");
	}
	
	Client::$system->image=$code->message->id();
	if (!Client::$system->edit('image')){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::extra("image", FileDB::link(Client::$system->image));
	
	Ajax::release(Code::success());
?>