<?php

	/**
	 * @desc Drag and drop userlist
	 */

	
	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	$system=\Client::$system;
	
	
	$imp=new \base\Importer(["plain"=>true]);
	$imp->header("name", "path", "leader", "members", "about");
	$imp->upload("file");
	
	if ($imp->hasError()){
		Ajax::release($imp->getError());
	}

	$rows=$imp->getRows();
	$rows=\ARR::filter($rows, function($e, $index){
		if ($index==0){
			return false;
		}
		
		return true;
	});
	
	$dup=ARR::findDuplication($rows, function($e, $f){
		return $e->path ==$f->path;
	});
	
	if ($dup){
		Ajax::release("Duplicated path: {$dup->path}");
	}
	
	$dup=ARR::single($rows, function($e){
		if (\Word::isEmpty($e->name)){
			continue;
		}
		
		if (!\Valid::usernameStrict($e->path)){
			Ajax::release("Path invalid: {$e->name}");
		}
		
		if (Network::reservedKeyword($e->path)){
			Ajax::release("The path {$e->path} is reserved. Please use another path.");
		}
		
		if (\Word::isEmpty($e->leader)){
			Ajax::release("No leader: {$e->name}");
		}
	});
	
	
	foreach ($rows as $r){
		$network=new Network();
		$network->system(Client::$system);
		$network->name=$r->name;
		$network->path=$r->path;	
		$network->metatype="unit";
		$network->type=3;
		$network->about=$r->about;
		$network->num_people=1;
		
		
		$leader=User::withUsername($r->leader);
		if ($leader){
			$network->user($leader);
		}else{
			Ajax::release("Unit leader isn't set.");
		}
		
		if (!Valid::usernameStrict($network->path)){
			Ajax::release("INVALID PATH. IT SHOULD HAVE AT LEAST 3 CHARACTERS.");
		}
		
		if (Network::reservedKeyword($network->path)){
			Ajax::release("INVALID PATH. YOU CANNOT USE THIS PATH (".$network->path.").");
		}
		
		if (!inset($network->type, Network::TYPE_PUBLIC, Network::TYPE_RESTRICTED)){
			Ajax::release("TYPE.INVALID");
		}
		
		if ($network->exist('path, system_id')){
			Ajax::release("PATH.DUPLICATED");
		}
		
		$network->parent_id=0;
		if (!$network->save()){
			SQL::markError();
			Ajax::release(Code::DB_ERROR);
		}
			
		if (!$network->setCreator($leader)){
			SQL::markError();
			Ajax::release(Code::DB_ERROR);
		}
		
		
		
		// Set people to the business units
		$usernames=(Word::split(array(" ",",",";","\n"), $r->members));
		$usernames=ARR::unique($usernames);
		
		$success=[];
		$followers=[];
		
		
		foreach ($usernames as $u){
			if (Word::prefix($u,"@")){
				$u=substr($u,1);
			}
			
			$u=safe($u);
			
			$user=User::withUsername($u);
			if ($user && $user->good() && $user->id!=$leader->id){
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
		
		// Set message channel
		if (!$network->createMessageChannel()){
			Ajax::release(Code::DB_ERROR);
		}
		
		
		\Event::pushSystem("system.unit.new", Client::$system, $network->release());
	}
	
	
	
	Ajax::release(Code::success());
?>