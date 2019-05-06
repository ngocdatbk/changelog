<?php 

	/**
	 * @desc Delegate on leave
	 */

	$user=User::withUsername(HTML::inputInline("username"));

	if ($user && $user->id == Client::$viewer->id){
		Ajax::release("You cannot delegate for yourself");
	}

	
	if (!$user){
		Client::$viewer->data->delegate=(object)[
			"enabled"=>0,
			"username"=>""
		];
	}else{
		$from=HTML::inputDate("sdate");
		$to=HTML::inputDate("edate");
		
		if (!$from || !$to || $from>$to){
			Ajax::release("The from-date or to-date is invalid");
		}
		
		Client::$viewer->data->delegate=(object)[
			"enabled"=>1,
			"username"=>$user->username,
			"sdate"=>$from,
			"edate"=>$to
		];
	}
	
	Client::$viewer->edit("data");

	Ajax::release(Code::success("Set delegation successfully ..."));
	
?>