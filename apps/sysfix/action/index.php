<?php 

	\Debugger::showQuery();
	syscron(function($system){
		/**
		 * @var unknown $users
		 */
		$users=$system->getUsers(1000);
		foreach ($users as $user){
			if ($user->isGuest()){
			}else{
				$role=$user->getPriv($system);
				$user->role=$role;
				$user->edit("role");
			}
		}
	});

	
	exit;
	
?>