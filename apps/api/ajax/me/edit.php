<?php 

	Client::$viewer->first_name=HTML::inputInline("first_name");
	Client::$viewer->last_name=HTML::inputInline("last_name");
	Client::$viewer->title=HTML::inputInline("title");
	
	Client::$viewer->data->phone=HTML::inputInline("phone");
	Client::$viewer->data->address=HTML::inputInline("address");
	
	
	if (\Word::isEmpty(Client::$viewer->first_name)){
		Ajax::release("FIRST_NAME_EMPTY");
	}
	
	if (\Word::isEmpty(Client::$viewer->last_name)){
		Ajax::release("LAST_NAME_EMPTY");
	}
	
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
	
	
	Client::$viewer->data->dob_day=$dob_day;
	Client::$viewer->data->dob_month=$dob_month;
	Client::$viewer->data->dob_year=$dob_year;
	

	FileDB::ns("tmp");
	$code=FileDB::upload("image", Client::$viewer);
	
	if ($code->good()){
		FileDB::ns("");
		FileDB::setTransparency(false);
		$id=$code->message->id();
		$dup=Client::$viewer->setGlobalAvatar($id);
		$file=FileDB::link($dup);
		
		
		$avatar=User::avatar(Client::$viewer->username);
	}
	

	Client::$viewer->save();
	Client::$viewer->syncUnit();
	
	Client::$viewer->unload();
	
	Ajax::extra("viewer", Client::$viewer->releaseFull());
	Ajax::release(Code::success("Update profile successfully"));
?>