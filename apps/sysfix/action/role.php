<?php 

	/**
	 * @desc Correctly fix role
	 */

	syscron(function($sys){
		if (\Client::$system->id!=1){
			// return;
		}
		
		$users=\Client::$system->getAllUsers(5000);
		foreach ($users as $user){
			if (!$user->data->has("__role")){
				$user->data->__role=$user->role;
				$user->data->__status=$user->status;
				
				if ($user->status!=-1){
					$user->status=$user->role;
					if ($user->status>1){
						$user->status=1;
					}
				}
					
				if ($user->role==-1){
					$user->status=-1;
				}
					
				$user->role=$user->getPriv(\Client::$system);
					
				$user->edit("status, role, data");
			}
			
			$user->show();
		}
	});
	
	exit;

?>