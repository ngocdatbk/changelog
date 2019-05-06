<?php 

	$order=HTML::inputInt("order");

	$network=new Network(HTML::inputInt("id"));
	if (!$network->good() || !$network->hasMember(Client::$viewer)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$networks=Client::$viewer->networks;
	 
	$len=count($networks);
	
	if ($order==1){
		for ($i=0; $i<$len; $i++){
			if ($networks[$i]==$network->id && $i<$len-1){
		 		$temp=$networks[$i];
		 		$networks[$i]=$networks[$i+1];
		 		$networks[$i+1]=$temp;
		 		$i++;
		 	}
		}
	}else{
		for ($i=$len-1; $i>=0; $i--){
			if ($networks[$i]==$network->id && $i>0){
		 		$temp=$networks[$i];
		 		$networks[$i]=$networks[$i-1];
		 		$networks[$i-1]=$temp;
		 		$i--;
		 	}
		}
	}
	
	Client::$viewer->networks=$networks;
	Client::$viewer->edit('networks');
	
	Ajax::release(Code::success());

?>