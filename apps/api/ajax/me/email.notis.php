<?php 

	$eo=new \base\EmailOpt(\Client::$viewer);
	
	$eo->update(\HTML::inputInline("name"), \HTML::inputInline("value"));

	Ajax::extra("email_options", $eo->release());
	Ajax::release(Code::success());
?>