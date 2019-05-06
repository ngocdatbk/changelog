<?php

	layout("mainapp","~layout.tpl");
	
	$people=Client::$system->getUsers(500);
	
	Client::pageData("people", ARR::select($people, function(&$p){
// 		$obj=$p->releaseWithRole();
// 		$obj->ms=$p->member->release();
// 		$obj->ips=$p->data->get("ips");
// 		$obj->since=$p->member->since;
// 		return $obj;

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
	
	
	
	if (HTML::getInt("export") && \this\sysadmin()){
		$export=new \export\Excel(Client::$system->path.".members");
		$export->sheet("Members", Client::$system->path, false);
		$export->header(["Last name", "First name", "Email", "Username", "Job title", "Date of Birth", "Phone number", "Address", "Managers"], []);
		
		foreach ($people as $p){
			$dob=$p->data->getInt("dob_day")."/".$p->data->getInt("dob_month")."/".$p->data->getInt("dob_year");
			if ($dob=="0/0/0"){
				$dob="";
			}
			$export->addRow([$p->last_name, $p->first_name, $p->email, $p->username, $p->title, $dob, $p->phone, $p->address, \Word::join(", ",$p->manager)]);
		}
		
		$export->save()->transfer();
		exit;
	}
	
?>