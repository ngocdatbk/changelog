<?php 

	layout("mainapp","~deactivated.tpl");
	
	$people=User::find("status=-1 and system_id='".Client::$system->id."'", "*", 500);
	
	Client::pageData("people", ARR::select($people, function(&$p){
		$obj=$p->release();
		$obj->ips=$p->data->get("ips");
		return $obj;
	}));
	
?>