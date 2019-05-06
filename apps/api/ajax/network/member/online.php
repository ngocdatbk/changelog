<?php 

	$network=new Network(HTML::inputInt('network'));
	
	if (!$network->good() || !$network->hasMember(Client::$viewer)){
		Ajax::release(Code::INVALID_DATA);
	}

	$people=$network->getPeople();

	Ajax::extra("people", ARR::select($people, function(&$p){
		// if (!Online::isOnline($p)){
			// return null;
		// }
		return $p->releaseWithRole();
	}));

	Ajax::release(Code::success());
?>