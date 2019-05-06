<?php 

	### REQUIRE FOR ALL CRON JOBS ###
	### PLEASE DONT REMOVE THOSE LINES ###
	
	$dir=dirname(__FILE__);
	require_once($dir."/../init.php");
	Request::commandLine();
	
	### END OF REQUIREMENTS ###

	
	$paths=Word::split("/",$argv[1]);
	
	if ($paths[0]=="ap"){
		require_once(AP_ROOT."/../".$argv[1]);
	}else{
		require_once(ROOT_DIR."/var/".$argv[1]);
	}
?>