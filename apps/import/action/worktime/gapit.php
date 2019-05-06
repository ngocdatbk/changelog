<?php 

	set_time_limit(2000);


	function sync_profile_image($user, $url){
		$code=\FileDB::download($url, "png, jpg, jpeg");
		if ($code && $code->good()){
			$user->image=$code->message->id();
			$user->edit('image');
		}
	}


	$headers = array('Accept' => 'application/json');
	$token="mitigrateWTBaseX2016";
	$company="gapit";
	
	$url="http://bonbon-api.gapit.com.vn/mitigrate/teamup?company={$company}&__token=$token";
	
	$request = \unirest\Request::get($url, $headers);

	if (!isset($request->body->system) || !isset($request->body->users)){
		exit("INVALID.API.USERS.OR.SYSTEM.NOT.FOUND");
	}
	
	
	// Create system
	
	$sysdata = $request->body->system;
	$usersdata = $request->body->users;
	
	$system=new sys\System();
	$system->name=$sysdata->name;
	$system->path=$sysdata->path;
	
	if (!Valid::length($system->name,3,200)){
		exit("COMPANY.NAME.INVALID");
	}
	
	if (!Valid::subdomain($system->path)){
		exit("COMPANY.DOMAIN.INVALID");
	}
	
	if (Network::reservedKeyword($system->path)){
		exit("YOU CANNOT USE THIS PATH (".$system->path.").");
	}
	
	if ($system->unique('path')){
		
		if (!$system->save()){
			SQL::markError();
			Ajax::release(Code::DB_ERROR);
		}
	}else{
		$system=\sys\System::single("path='{$system->path}'");
	}
	
	if (!$system || !$system->good()){
		exit("INVALID.SYSTEM");
	}
	
	FileDB::ns("sys".$system->id);
	
	
	
	// OKAY, REGISTERING NEW USERS
	
	$users=[];
	
	for ($i=0; $i<count($usersdata); $i++){
		$userdata=$usersdata[$i];
		
		$existed=false;
		$user=new User();
		
		$check=User::single("email='{$userdata->email}'");
		if ($check){
			$existed=true;
			$user=$check;
		}
		
		$user->first_name=$userdata->first_name;
		$user->last_name=$userdata->last_name;
		$user->email=$userdata->email;
		$user->username=$userdata->username;
		$user->title=$userdata->title;
		$user->priv=$userdata->priv_s;
		
		$user->password=""; // Incomplete password, unactivated accounts
		$user->data->password_import=$user->password;
		
		
		$user->data->phone=$userdata->phone;
		$user->data->address=$userdata->address;
		

		if (!Valid::email($user->email)){
			Ajax::release("The email is empty or invalid.");
		}
		
		if (Word::isEmpty($user->first_name)){
			exit("The first name is empty");
		}
		
		if (Word::isEmpty($user->last_name)){
			exit("The last name is empty");
		}
		
		if (Word::isEmpty($user->username)){
			exit("The user is empty");
		}
		
		
		if (!Valid::usernameStrict($user->username)){
			exit("The username is not valid");
		}
		
		if (Network::reservedKeyword($user->username)){
			exit("The username is a reserved name. Please use another username.");
		}
		
		
		if (!$existed){
			$code=$user->register();
			if (!$code->good()){
				exit("CANNOT REGISTER USER @{$user->username}");
			}
			
			if (!$system->createUserNetwork($user)){
				SQL::markError();
				exit("CANNOT CREATE THE SELF TEAM FOR @{$user->username}");
			}
		}else{
			if (!$user->save()){
				exit("CANNOT SAVE USER @{$user->username}");
			}
		}
		
		
		$users[]=$user;
	}
	
	
	
	foreach ($users as $user){
		if (!$user->image){
			sync_profile_image($user, $userdata->image);
		}
	}
	
	
	
	// OKAY, CREATING ROOT NETWORK
	
	// Create root team
	$root=$system->rootNetwork();
	
	if (!$root){
		$rootuser=ARR::single($users, function($e){
			return $e->priv==13;
		});
	
		if (!$rootuser){
			SQL::markError();
			exit("CANNOT FIND ROOT USER");
		}


		if (!$system->setCreator($rootuser)){
			SQL::markError();
			exit("CANNOT SET SYSTEM CREATOR");
		}


		$root=$system->createRootNetwork();

		if (!$root){
			SQL::markError();
			exit("CANNOT CREATE ROOT NETWORK");
		}
	
	}
	
	
	
	// OKAY, linking users and root networks
	
	for ($i=0; $i<count($users); $i++){
		$user=$users[$i];
		
		if (Member::getObject($root, $user)){
			// SKIP LINKING
			continue;
		}
		
		if (!$system->addMember($user, $root, \Member::REGULAR)){
			SQL::markError();
			exit("CANNOT ADD @{$user->username} TO THE ROOT TEAM");
		}
	}
	
	echo "Success", "\n";
	
	$root->show();
	$system->show();
	
	exit;
?>