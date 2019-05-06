<?php

	/**
	 * @desc Drag and drop userlist
	 */

	set_time_limit(1000);
	
	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	$system=\Client::$system;
	FileDB::ns("sys".Client::$system->id);
	
	$imp=new \base\Importer(["plain"=>true]);
	$imp->header("last_name", "first_name", "email", "username", "title", "dob", "phone", "address", "manager");
	$imp->upload("file");
	
	if ($imp->hasError()){
		Ajax::release($imp->getError());
	}

	$rows=$imp->getRows();
	
	$rows=\ARR::filter($rows, function($e, $index){
		if ($index==0){
			return false;
		}
		
		if (!\Valid::email($e->email)){
			return false;
		}
		
		return true;
	});
	
	
	$dup=ARR::findDuplication($rows, function($e, $f){
		return $e->email ==$f->email || $e->username == $f->username;
	});
	
	if ($dup){
		Ajax::release("Duplicated username or email: {$dup->first_name} {$dup->last_name}");
	}
	
	$count=0;
	$dup=ARR::single($rows, function($e)use(&$count){
		$count++;
		if (\Word::isEmpty($e->first_name)){
			Ajax::release("First name empty [Row $count]: {$e->first_name} {$e->last_name}");
		}
		
		if (\Word::isEmpty($e->last_name)){
			Ajax::release("Last name empty [Row $count]: {$e->first_name} {$e->last_name}");
		}
		
		if (\Word::isEmpty($e->email)){
			Ajax::release("Email empty [Row $count]: {$e->first_name} {$e->last_name}");
		}
		
		if (!\Valid::email($e->email)){
			Ajax::release("Email invalid [Row $count]: {$e->first_name} {$e->last_name}");
		}
		
		if (\Word::isEmpty($e->username)){
			Ajax::release("Username empty [Row $count]: {$e->first_name} {$e->last_name}");
		}
		
		if (!\Valid::usernameStrict($e->username)){
			Ajax::release("Username invalid [Row $count]: {$e->first_name} {$e->last_name} {$e->username}");
		}
		
		if (Network::reservedKeyword($e->username)){
			Ajax::release("The username {$e->username} is a reserved name. Please use another username.");
		}
	});
	
	$rows=array_reverse($rows);
	
	foreach ($rows as $r){
		$password=Word::random(10);
		$user=new User();
		$user->system_id=$system->id;
		
		$user->first_name=$r->first_name;
		$user->last_name=$r->last_name;
		
		$user->email=$r->email;
		$user->username=$r->username;
		
		if (Network::reservedKeyword($user->username)){
			continue;
		}
		
		$user->title=$r->title;
		if (\Valid::phone($r->phone)){
			$user->data->phone=$r->phone;
		}
		$user->data->address=$r->address;
		
		if ($user->exist('email')){
			// Ajax::release("The email is existed before in your company. The account is NOT yet created.");
			continue;
		}
		
		if ($user->exist('username, system_id')){
			// Ajax::release("The username is existed before (for another user). Please use another username.");
			continue;
		}
		
		if (Network::single("path='{$user->username}' and system_id='{$system->id}'")){
			// Ajax::release("The username is existed before (for another user). Please use another username.");
			continue;
		}
		
		
		
		if ($r->dob){
			$date=HTML::inputDate($r->dob, HTML::REAL);
			if ($date){
				$user->data->dnd=$date;
			}
		}

		$user->password=$password;
	
		$code=$user->register();
		
		if (!$code->good()){
			SQL::markError();
			Ajax::release($code);
		}
		
		
		$root=Client::$system->rootNetwork();
		
		if (!Client::$system->addMember($user, $root, \Member::REGULAR)){
			SQL::markError();
			Ajax::release(Code::DB_ERROR);
		}
		
		if (!Client::$system->createUserNetwork($user)){
			SQL::markError();
			Ajax::release(Code::DB_ERROR);
		}
		
		
		\SocketIO::send("system.user.new", $user->release());
		
		if (ENV==1){
			\mail\account\create($user, $password);
		}
	}
	
	
	
	// Set manager
	foreach ($rows as $r){
		$user=User::withUsername($r->username);
		if ($user && $user->good()){
			$managers=UserList::extractString($r->manager);
			if ($managers->length()){
				$managers->remove([$user]);
				$user->manager=$managers->usernames();
				$user->edit("manager");
				$user->unload();
			}
		}
	}
	
	Ajax::release(Code::success());
?>