<?php 

	if (!\this\sysowner()){
		APT::redirect("home");
	}

	$app=Action::tail(":first");
	
	if ($app && inset($app, "tudien", "thoigian", "drive")){
		post("app", $app);
		layout("mainapp", "~confirm.tpl");
	}else{
		APT::redirect("home");
	}

	css("~layout.css");
?>