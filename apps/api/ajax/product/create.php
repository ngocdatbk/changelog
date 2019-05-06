<?php 


	if (!\this\sysadmin()){
//		Ajax::release(Code::INVALID_AUTHENTICATION);
	}


	/**
	 * @desc Create a new business unit
	 */

	SQL::commit();

	$name=HTML::inputInline("name");
	$current_version=strtolower(HTML::inputInline("current_version"));
	$writers=HTML::inputInline("writers");
	$subscribers=HTML::inputInline("subscribers");
	
	$product=new \changelog\Product();
	$product->user(Client::$viewer);
	$product->system(Client::$system);

//    $product->name=$name;
    if (!$product->save()){
        SQL::markError();
        Ajax::release(Code::DB_ERROR);
    }

    Ajax::extra("network", $product->export());
    Ajax::release(Code::success());

    exit();

	$product->name=$name;
	$product->path=$path;
	$product->type=$type;
	$product->about=$about;
	$product->num_people=1;
	$product->about=$about;
	$product->metatype="unit";
	
	
	if (!Valid::usernameStrict($product->path)){
		Ajax::release("INVALID PATH. IT SHOULD HAVE AT LEAST 3 CHARACTERS.");
	}
	
	if (Network::reservedKeyword($product->path)){
		Ajax::release("INVALID PATH. YOU CANNOT USE THIS PATH (".$product->path.").");
	}
	
	if (!inset($product->type, Network::TYPE_PUBLIC, Network::TYPE_RESTRICTED)){
		Ajax::release("TYPE.INVALID");
	}
	
	if ($product->exist('path, system_id')){
		Ajax::release("PATH.DUPLICATED");
	}
	
	
	$parent=Client::$system->rootNetwork();
	if (!$parent){
		\Ajax::release("ROOT_NETWORK_NOT_FOUND");
	}
	

	
	$product->setParent($parent);
	
	
	$leader=User::withUsername(HTML::inputInline("leader"));
	if ($leader){
		$product->user($leader);
	}else{
		Ajax::release("Business leader isn't set.");
	}
	
	
	if (!$product->save()){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
		
	if (!$product->setCreator($leader)){
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
			if ($product->hasMember($user)){
				continue;
			}
			
			// Add to network
			
			if (!$product->addMember($user, Member::REGULAR)){
				Ajax::release(Code::DB_ERROR);
			}
			
			\mail\network\confirmInvitation($user, Client::$viewer, $product);
			
			$success[]=$user->username;
			$followers[] = $user;
		}
	}
	
	
	
	// Set message channel
	// 	if (!$product->createMessageChannel()){
	// 		Ajax::release(Code::DB_ERROR);
	// 	}
	
	\Event::pushSystem("system.unit.new", Client::$system, $product->release());
	
	
	// Add people to the business unit
	
	Ajax::extra("network", $product->export());
	Ajax::release(Code::success());
?>