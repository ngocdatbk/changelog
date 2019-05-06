<?php 

	// Setting membership
	

	$network=new Network(HTML::inputInt('network'));
	if (!$network->local()){
		Ajax::release(Code::DB_ERROR);
	}
	
	
	\this\requireAdmin($network);
	
	if ($network->image){
		FileDB::delete($network->image);
		$network->image="";
		if ($network->edit('image')){
			Ajax::release(Code::success());
		}else{
			Ajax::release(Code::DB_ERROR);
		}
	}
	
	$network->unload();
	
	Ajax::release(Code::success());
	
?>