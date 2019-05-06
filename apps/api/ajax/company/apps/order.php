<?php 

	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$applist=new \sys\AppList(Client::$system);

	$app=$applist->getApp(HTML::inputInline("id"));
	if (!$app){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if (HTML::inputInt("order")==-1){
		$applist->up($app);
	}else{
		$applist->down($app);
	}
	
	if (!$applist->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::extra("applist", $applist->release());
	Ajax::release(Code::success());
?>