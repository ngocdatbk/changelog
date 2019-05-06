<?php 

	/**
	 * @desc Setting subscriptions for apps
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$sub=\HTML::inputInline("app");
	$usernames=\HTML::inputUsers("usernames");
	
	
	$teams=\TeamList::extractInput("teams");
	$teams=$teams->teams();
	
	$users=\Client::$system->getUsersInGroups($teams);
	
	$users=\ARR::select($users, function($e){
		return $e->username;
	});
	
	$users=array_merge($users, $usernames);
	
	$users=\ARR::unique($users);

	
	for ($i=0; $i<count(Client::$system->subs);  $i++){
		if (isset(Client::$system->subs[$i]) && Client::$system->subs[$i]->app==$sub){
			$limit=Client::$system->subs[$i]->limit;
			
			if ($limit>0 && $limit<count($usernames)){
				Ajax::release("ERROR: The subscription could have a maximal of $limit users.");
			}
			
			Client::$system->subs[$i]->users=$users;
		}
	}
	
	Client::$system->edit("subs");
	\Ajax::release(Code::success());

?>