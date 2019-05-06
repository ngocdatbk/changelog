<?php

$network = Network::withHID(HTML::inputInline("hid"));

if (!$network || !$network->tokenMatched()) {
	Ajax::release(Code::INVALID_DATA);
}

if ($network->isRoot()) {
	Ajax::release("Cannot delete the company network.");
}


if (!\this\sysowner()) {
	Ajax::release(Code::INVALID_AUTHENTICATION);
}

$num_children = Network::count("parent_id = {$network->id} AND system_id = " . \Client::$viewer->system_id);
if ($num_children > 0) {
	Ajax::release("Please remove all sub-networks first.");
}

// Revoke accesss of all users first
$members = $network->getPeople(0);

// cache owners for email notice
$nw_managers = [];

$nid = $network->id;
SQL::commit();
for ($i = 0; $i < count($members); $i++) {
	$mem = Member::getObject($network, $members[$i]);
	if (!$mem) {
		continue;
	}

	if ($mem->role != Member::REGULAR) {
		$nw_managers[] = $members[$i];
	}

	if (!$mem->delete()) {
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}

	$members[$i]->networks = ARR::filter($members[$i]->networks, function($e) use($nid){
		if ($e == $nid) {
			return false;
		}

		return true;
	});

	if (!$members[$i]->edit("networks")){
		SQL::markError();
		Ajax::release(Code::DB_ERROR);
	}

	$members[$i]->unload();
}

// Delete network
if (!$network->delete()){
	SQL::markError();
	Ajax::release(Code::DB_ERROR);
}

// Notify to all admins and owners via email
$timeNow = time();
$msg = "<b>" . \Client::$viewer->name . "</b> (@" . \Client::$viewer->username . ") deleted network <b>{$network->name}</b> at <b>" . date("H:i - d/m/Y", $timeNow) . "</b>";
foreach ($nw_managers as $nw_manager) {
	mail\network\push($nw_manager->email, $network, "Network was deleted by @" . \Client::$viewer->username,"
		<p>Dear <b>{$nw_manager->name}</b>,</p>
		<p>{$msg}</p>
	");
}

foreach ($members as $m) {
	N::create($network->hid())
		->type("network:remove")
		->title($msg)
		->image(User::avatar(Client::$viewer->username))
		->data($network->export())
		->to($m)
		->except(Client::$viewer)
		->notify()
		->notifyMobiles()
		->save();
}


Ajax::release(Code::success());

?>