<?php 

	Setting::add("system",[
		"name"=>["*username","fullname"],
		"title"=>["*yes","no"],
		"invite"=>["*admin","owner"],
		"task_create"=>["*yes","no"],
		"task_comment"=>["yes","*no"],
		"request_create"=>["*yes","no"],
		"request_comment"=>["yes","*no"],
		"job_create"=>["*yes","no"],
		"job_comment"=>["yes","*no"]
	]);


	Setting::add("team",[
		"update"=>["*everyone","admin","owner"],
		"announcement"=>["everyone","*admin","owner"],
		"topic"=>["*everyone","admin","owner"],
		"announcement_extra" => ":custom:users",
		"tagall"=>["*everyone","admin","owner"],
		"delete_post"=>["*yes","no"],
		"share"=>["*yes","no"],
		"leave"=>["*yes","no"]
	]);

	
	Setting::add("teampref",[
		"share"=>["*yes","no"]
	]);
	
	
	Setting::add("onboards", [
		"requires"=>["tos","welcome"]
	]);
	
?>