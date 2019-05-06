<?php 

	if (HTML::get("email") && HTML::get("state")){
		layout("main","~guest.password.tpl");
	}else{
		layout("main","~guest.recover.tpl");
	}
	
	btitle("Recover Client Password");

?>