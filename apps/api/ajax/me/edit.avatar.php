<?php 

	FileDB::setTransparency(false);
	FileDB::ns("tmp");
	FileDB::setSize(2, 300, 300);
	
	$code=FileDB::upload("image", Client::$viewer);
	
	if ($code->good()){
		FileDB::ns("");
		$dup=Client::$viewer->setGlobalAvatar($code->message->id());
	}else{
		Ajax::release("Cannot upload the file");
	}
	
	Client::$viewer->save();
	Client::$viewer->unload();
	
	Ajax::release(Code::success("Update profile successfully"));
?>