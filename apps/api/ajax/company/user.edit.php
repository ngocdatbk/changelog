<?php 

	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}

	$role=$user->getPriv(Client::$system);
	if ($role==Member::OWNER && !\this\sysowner()){
		Ajax::release("Oops... you are not allowed to edit this profile.");
	}
	
	$user->first_name=HTML::inputInline("first_name");
	$user->last_name=HTML::inputInline("last_name");
	$user->title=HTML::inputInline("title");
	
	$user->data->phone=HTML::inputInline("phone");
	$user->data->address=HTML::inputInline("address");
	
	
	// Check DOB
	$dob_day=HTML::inputInt("dob_day");
	$dob_month=HTML::inputInt("dob_month");
	$dob_year=HTML::inputInt("dob_year");
	
	if ($dob_day && inrange($dob_day, 1, 31)){
	}else{
		$dob_day=0;
	}
	
	if ($dob_month && inrange($dob_month, 1, 12)){
	}else{
		$dob_month=0;
	}
	
	if ($dob_year && inrange($dob_year, 1900, 2100)){
	}else{
		$dob_year=0;
	}
	
	
	if ($dob_day && $dob_month && $dob_year){
		if (checkdate($dob_month, $dob_day, $dob_year)){
		}else{
			$dob_month=0;
			$dob_year=0;
		}
	}
	
	
	$user->data->dob_day=$dob_day;
	$user->data->dob_month=$dob_month;
	$user->data->dob_year=$dob_year;
	
	FileDB::ns("temp");
	FileDB::setSize(2, 300, 300);
	
	$code=FileDB::upload("image", $user, FileDB::IMAGE_TYPES);
	
	if ($code->good()){
		FileDB::ns("");
		
		$id=$code->message->id();
		$user->setGlobalAvatar($id);
	}
	
	$user->save();
	$user->syncUnit();
	$user->unload();
	
	Ajax::release(Code::success("Update profile successfully"));
?>