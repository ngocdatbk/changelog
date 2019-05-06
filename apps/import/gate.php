<?php

	define("MITIGRATE_TOKEN","mitigrateWTBaseX2016");
	
	if (MITIGRATE_TOKEN != HTML::get("__token")){
		exit("You cannot access this URL");
	}

?>