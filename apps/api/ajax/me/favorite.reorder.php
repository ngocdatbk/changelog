<?php 

	$order=HTML::inputInt("order");
	if (!inset($order,1,0,-1)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$favors=Client::$viewer->data->get("fs");
	if (!$favors){
		$favors=[];
	}
	
	$id=HTML::inputInline("id");
	
	if (!ARR::contain($favors, $id)){
		Ajax::release(Code::INVALID_DATA);
	}
	
		
	$len=count($favors);
	
	if ($order==-1){
		for ($i=0; $i<$len; $i++){
			if ($favors[$i]==$id && $i<$len-1){
				$temp=$favors[$i];
				$favors[$i]=$favors[$i+1];
				$favors[$i+1]=$temp;
				$i++;
			}
		}
	}else{
		for ($i=$len-1; $i>=0; $i--){
			if ($favors[$i]==$id && $i>0){
				$temp=$favors[$i];
				$favors[$i]=$favors[$i-1];
				$favors[$i-1]=$temp;
				$i--;
			}
		}
	}
	
	Client::$viewer->data->fs=$favors;
	if (!Client::$viewer->edit('data')){
		Ajax::release(Code::DB_ERROR);
	}
	
	
	
	Ajax::extra("favors", Client::$viewer->releaseFavorites());
	Ajax::release(Code::success());
	
?>