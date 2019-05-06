<?php 
	layout("mainapp","~layout.tpl");
	
	$people=User::find("system_id='".Client::$system->id."' and metatype='guest'");
	Client::pageData("guests", ARR::select($people, function(&$p){
		return $p->release();
	}));
?>