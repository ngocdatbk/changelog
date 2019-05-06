<?php 

	$color=HTML::inputInt("color");
	if (inrange($color,1,9)){
		Client::$viewer->color=$color;
		Client::$viewer->edit('color');
	}

	Ajax::extra("me", Client::$viewer->release());
	
	Client::$viewer->unload();
	
	Ajax::extra("color", $color);
	Ajax::release(Code::success());
?>