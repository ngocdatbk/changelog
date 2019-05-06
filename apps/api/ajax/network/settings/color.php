<?php 

	// Setting membership
	

	$network=new Network(HTML::inputInt('network'));
	
	\this\requireAdmin($network);
	
	$color= HTML::inputInt('color');
	if (!inrange($color, 1,10)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$network->color=$color;
	
	if (!$network->edit('color')){
		Ajax::release(Code::DB_ERROR);
	}
	
	$network->unload();
	
	Ajax::release(Code::success());
?>