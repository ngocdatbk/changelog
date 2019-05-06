<?php 

	/**
	 * @desc Sysfix deactivate
	 */

	syscron(function($system){
		$people=User::find("status=-1 and system_id='".Client::$system->id."'", "*", 1000);
		foreach ($people as $p){
			$p->unload();
		}
	});
	
	exit;

?>