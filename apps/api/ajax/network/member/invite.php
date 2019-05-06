<?php
	
	$network=new Network(HTML::inputInt('network'));
	
	if (!$network->good() || !$network->tokenMatched()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if ($network->isRoot()){
		Ajax::release("WRONG.PLACE");
	}
	
	if (!\this\sysowner()){
		\this\requireAdmin($network);
	}
	
	$usernames=Word::split(array(" ",",",";","\n"), HTML::inputRaw("usernames"));
	$success=[];
	$followers=[];
	
	foreach ($usernames as $u){
		if (Word::prefix($u,"@")){
			$u=substr($u,1);
		}
		
		$u=safe($u);
		
		$user=User::withUsername($u);
		if ($user && $user->good()){
			if ($network->hasMember($user)){
				continue;
			}
			
			// Add to network
			
			if (!$network->addMember($user, Member::REGULAR)){
				Ajax::release(Code::DB_ERROR);
			}
			
			\mail\network\confirmInvitation($user, Client::$viewer, $network);
			
			$success[]=$user->username;
			$followers[] = $user;
		}
	}
	
	
	if (count($success)){
		// Notify to users
		N::create($network->hid())
		->type("network:member")
		->title("@<b>".Client::$viewer->username."</b> added you to the team <b>{$network->name}</b>.")
		->image(User::avatar(Client::$viewer->username))
		->link($network->link())
		->data($network->export())
		->to($followers)
		->except(Client::$viewer)
		->notify()
		->notifyMobiles()
		->save();
		Ajax::extra("usernames", $success);
		Ajax::release(Code::success());
	}

	Ajax::release(Code::error("No one was added to {$network->name}"));
?>