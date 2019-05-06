<?php 

	// Get info

	Ajax::extra("user", Client::$viewer->releaseFull());
	
	Ajax::release(Code::success());
	
?>