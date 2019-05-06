<?php 

	// Setting membership
	

	$network=new Network(HTML::inputInt('network'));
	if (!$network->local()){
		Ajax::release(Code::DB_ERROR);
	}
	
	if ($network->isRoot()){
		Ajax::release("Cannot change the membership setting of the company");
	}
	
	\this\requireAdmin($network);
	
	$type= HTML::inputInt('type');
	if (!inset($type, Network::PUBLIC_OFFICE, Network::PRIVATE_OFFICE, Network::RESTRICTED_OFFICE)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$network->type=$type;
	
	if (!$network->edit('type')){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::release(Code::success());
?>