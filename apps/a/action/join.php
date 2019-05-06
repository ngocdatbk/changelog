<?php
	
	$user=null;
	
	if (BIG_SYSTEM){
		$user=User::withEmail(HTML::get("email"));
	}

	if (!$user){
		layout("main","~join.tpl");
	}else{
		post("user", $user);
		layout("main","~join.more.tpl");
	}
	
	
	

?>