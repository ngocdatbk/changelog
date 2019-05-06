<?php 


	if (!\this\sysadmin()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}


	/**
	 * @desc Create a new business unit
	 */

	SQL::commit();

	$name=HTML::inputInline("name");
	$path=strtolower(HTML::inputInline("path"));
	$type=HTML::inputInt("type");
	$about=HTML::inputSafe("about");
	
	$network=new Network();
	$network->user(Client::$viewer);
	$network->system(Client::$system);
	$network->name=$name;
	$network->path=$path;	
	$network->type=$type;
	$network->about=$about;
	$network->num_people=1;
	$network->about=$about;
	$network->metatype="unit";
	
	
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
	
	
	$parent=Client::$system->rootNetwork();
	if (!$parent){
		\Ajax::release("ROOT_NETWORK_NOT_FOUND");
	}
	
// 	$parent=new Network(HTML::inputInt("parent"));
	
// 	if (!$parent->good()){
		
// 	}
	
	
// 	if (!$parent || !$parent->good()){
// 		Ajax::release("Please set the parent unit.");
// 	}
	
// 	if ($parent->id==$network->id || $network->isAncestor($parent)){
// 		Ajax::release("The parent unit is not valid");
// 	}
	
	$network->setParent($parent);
	
	
	$leader=User::withUsername(HTML::inputInline("leader"));
	if ($leader){
		$network->user($leader);
	}else{
		Ajax::release("Business leader isn't set.");
	}
	
	
	if (!$network->save()){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
		
	if (!$network->setCreator($leader)){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	
	
	// Set people to the business units
	
	$usernames=(Word::split(array(" ",",",";","\n"), HTML::inputRaw("users")));
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
	// 	if (!$network->createMessageChannel()){
	// 		Ajax::release(Code::DB_ERROR);
	// 	}
	
	\Event::pushSystem("system.unit.new", Client::$system, $network->release());
	
	
	// Add people to the business unit
	
	Ajax::extra("network", $network->export());
	Ajax::release(Code::success());
?>