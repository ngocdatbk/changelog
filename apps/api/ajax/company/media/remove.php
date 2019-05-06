<?php 
	if (!\this\sysowner()){
		Ajax::release("Only system owner can change company media resource");
	}
	
	$id=HTML::inputInline("id");
	
	if (!inset($id, "logo_s24", "logo_w24", "logo_s32", "logo_w32", "logo_square_s", "logo_square_w")){
		Ajax::release("Invalid ID");
	}

	$media=Client::$system->data->getObject("media");
	
	if (isset($media->{$id})){
		unset($media->{$id});
		Client::$system->data->media=$media;
		Client::$system->edit("data");
	}
	
	Ajax::release(Code::success());
?>