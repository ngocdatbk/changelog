<?php 

	if (HTML::get("email") && HTML::get("state")){
		layout("mainapp","~password.tpl");
	}else{
		layout("mainapp","~recover.tpl");
	}
	
	btitle("Recover Password");

?>