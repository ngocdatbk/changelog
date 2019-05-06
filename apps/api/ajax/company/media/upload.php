<?php 

	if (!\this\sysowner()){
		Ajax::release("Only system owner can change company media resource");
	}

	\FileDB::setTransparency(true);
	
	$id=HTML::inputInline("id");
	
	if (!inset($id, "logo_s24", "logo_w24", "logo_s32", "logo_w32", "logo_square_s", "logo_square_w")){
		Ajax::release("Invalid ID");
	}
	
	$code=\FileDB::upload("image");
	
	if ($code && $code->good()){
		$media=Client::$system->data->getObject("media");
		$media->{$id}=$code->message->id();
		
		Client::$system->data->media=$media;
		Client::$system->edit("data");
	}
	
	
	Ajax::release(Code::success());

?>