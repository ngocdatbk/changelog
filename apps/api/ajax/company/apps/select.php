<?php 

	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$applist=new \sys\AppList(Client::$system);

	$app=$applist->getApp(HTML::inputInline("id"));
	if (!$app){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if (HTML::inputInt("value")==1){
		$applist->add($app);
	}else{
		$applist->remove($app);
	}
	
	
	if (!$applist->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::extra("applist", $applist->release());
	Ajax::release(Code::success());
?>