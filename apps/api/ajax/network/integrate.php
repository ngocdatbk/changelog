<?php 

	$network=new Network(HTML::inputInt('network'));
	
	this\requireAdmin($network);

	
	$apps=["work", "stream", "deal", "discuss", "wiki", "kbase"];
	
	$r=[];
	$featured="";
	
	foreach ($apps as $app){
		$code=HTML::inputInt($app);
		if ($code==1){
			$r[]=$app;
		}elseif ($code==2){
			if (!$featured){
				$featured=$app;
			}else{
				$r[]=$app;
			}
		}
	}
	
	if ($featured){
		array_unshift($r, $featured);
	}
	
	$network->data->apps=$r;
	
	if (!$network->edit('data')){
		Ajax::release(Code::DB_ERROR);
	}
	
	$network->unload();
	
	
	$apps=$network->data->get('apps');
	if (!count($apps)){
		$apps=["stream"];
	}
	
	Ajax::extra("network_apps", $apps);
	
	Ajax::release(Code::success());
?>