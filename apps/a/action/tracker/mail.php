<?php 

	// Tracking email read
	
	$stream=new \stream\Stream(Action::tail(":first"));
	$user=new User(Action::tail(":second"));
	$token=Action::tail(":third");
	
	
	if (!$stream->good() || $stream->company_id!=Client::$company->id || !$user->good() || $user->company_id!=Client::$company->id){
		exit("Bad Stream");
	}
	
	$key=md5($user->id."-".$stream->id."-".$stream->token);
	$flag=Flag::get($key);
	
	if ($flag){
	}else{
		Flag::set($key, $stream->gid(), ["username"=>$user->username,"id"=>$user->id],1);
		$stream->increase("num_reads");
		$stream->data->last_read=$user->username;
		$stream->edit("data");
	}

	header('Content-Type: image/gif');
	echo "\x47\x49\x46\x38\x37\x61\x1\x0\x1\x0\x80\x0\x0\xfc\x6a\x6c\x0\x0\x0\x2c\x0\x0\x0\x0\x1\x0\x1\x0\x0\x2\x2\x44\x1\x0\x3b";
?>