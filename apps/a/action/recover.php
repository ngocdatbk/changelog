<?php 

	if (HTML::get("email") && HTML::get("state")){
		layout("main","~password.tpl");
	}else{
		layout("main","~recover.tpl");
	}
	
	btitle("Recover Password");

?>