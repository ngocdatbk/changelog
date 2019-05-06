<?php 

	
	$about=HTML::inputSimple("aboutme");
	$interests=HTML::inputInline("interests");
	
	
	Client::$viewer->data->about=$about;
	Client::$viewer->data->interests=$interests;
	
	Client::$viewer->edit('data');
	
	Ajax::release(Code::success());

?>