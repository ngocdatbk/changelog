<?php 

	layout("mainapp","~layout.tpl");
	
	$people=Client::$system->getUsers(500);
	
	Client::pageData("people", ARR::select($people, function(&$p){
		$obj=$p->releaseWithRole();
// 		$obj->ms=$p->member->release();
// 		$obj->ips=$p->data->get("ips");
// 		$obj->since=$p->member->since;
//		return $obj;

		if ($p->metatype=="guest"){
			return null;
		}
		
		$obj=$p->release();
		$obj->ms=(object) ["role"=>$p->role];
		
		if (\this\sysadmin()){
			$obj->tfa_status=$p->data->getInt("tfa_status");
		}
		
		return $obj;
	}));
	
?>