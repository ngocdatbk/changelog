<?php
	/**
	 * @desc Create a new office
	 */
	
	SQL::commit();
	$network = Network::withHID(HTML::inputInline("hid"));
	
	if (!\this\sysadmin()) {
		if (!$network->hasMember(Client::$viewer) || !\this\owner($network)) {
			Ajax::release(Code::INVALID_AUTHENTICATION);
		}
	}
	
	if ($network->isRoot() && !\this\sysOwner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	if (!$network->tokenMatched()) {
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}
	
	$name = HTML::inputInline("name");
	$about = HTML::inputSafe("about");
	
	$network->name = $name;
	$network->about = $about;
	
	if (!$network->isRoot()) {
		$type = HTML::inputInt("type");
		$network->type = $type;
		if (!inset($network->type, Network::TYPE_PUBLIC, Network::TYPE_RESTRICTED)) {
			Ajax::release("TYPE.INVALID");
		}
	}
	
	
// 	if (!$network->isRoot()) {
// 		$official = HTML::inputInt("official");
	
// 		if ($official) {
// 			$parent = new Network(HTML::inputInt("parent"));
// 			if (!$parent) {
// 				Ajax::release("Please set the parent unit");
// 			}
	
// 			if ($parent->id == $network->id || $network->isAncestor($parent)) {
// 				Ajax::release("The parent unit is not valid");
// 			}
	
// 			$network->setParent($parent);
// 		} else {
// 			// $network->setOfficial(false);
// 		}
// 	}
	
// 	$current_leader = $network->user_id;
// 	$leader = User::withUsername(HTML::inputInline("leader"));
	
// 	if ($network->isOfficial() && !$leader) {
// 		Ajax::release("Please set the official team leader");
// 	}else{
// 		$leader->unload();
// 	}
	
//	if ($leader->id != $current_leader) {
// 		$network->user($leader);
	
// 		if ($network->isRoot()) {
// 			$mb = sys\Member::single("user_id = '" . $leader->id . "' AND origin_id = '" . $network->id . "'");
// 			if (!$mb) {
// 				Ajax::release("@{$leader->username} is not in this company.");
// 			}
			
// 			$mb->role = MEMBER::OWNER;
// 		} else {
// 			$mb = Member::single("user_id = '" . $leader->id . "' AND origin_id = '" . $network->id . "'");
// 			if (!$mb) {
// 				Ajax::release("@{$leader->username} is not in this team.");
// 			}
			
// 			$mb->role = MEMBER::OWNER;
// 		}
	
// 		if (!$mb->save()) {
// 			Ajax::release(Code::DB_ERROR);
// 		}
	
// 		N::create($network->hid())
// 			->type("network:role")
// 			->title("<b>" . Client::$viewer->name . "</b> set you as <b>official leader</b> of <b>{$network->name}</b>.")
// 			->image(User::avatar(Client::$viewer->username))
// 			->link($network->link())
// 			->data($network->export())
// 			->to($leader)
// 			->except(Client::$viewer)
// 			->notify()
// 			->notifyMobiles()
// 			->save();
//	}
	
	
	if (!$network->save()) {
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}
	
	$network->unload();
	
	Ajax::extra("network", $network->export());
	Ajax::release(Code::success());
?>