<?php 
	$lang=HTML::inputInline("lang");

	if (!inset($lang, "vi", "en")){
		Ajax::release(Code::INVALID_DATA);
	}
	
	Client::$viewer->data->lang=$lang;
	Client::$viewer->edit("data");
	Ajax::release(Code::success());
?>