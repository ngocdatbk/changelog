<?php

	if (Client::$viewer->auth()){
		if (!Client::$system->good()){
			exit("Invalid system");
		}
		
		
		$sysimage="";
		if (Client::$system->image && strlen(Client::$system->image)){
			$sysimage=FileDB::link(Client::$system->image);
		}
		
		Client::data("system",[
			"id"=>Client::$system->id,
			"hid"=>Client::$system->hid(),
			"type"=>"system",
			"name"=>Client::$system->name,
			"domain"=>Client::$domain,
			"path"=>Client::$system->path,
			"user_id"=>Client::$system->user_id,
			"num_people"=>User::count("system_id = ".Client::$system->id),
			"token"=>Client::$system->getSecuredToken(),
			"settings"=>Setting::release(Client::$system,"system"),
			"root_network_id"=>Client::$system->rootNetworkID(),
			"tosdoc"=>(Client::$system->data->get('tosdoc') == "") ? "" : FileDB::link(Client::$system->data->get('tosdoc')),
			"image"=>$sysimage,
			"privacy"=>Client::$system->data->getInt("privacy"),
			"applist"=>(new \sys\AppList(Client::$system))->release(),
			"user_limit"=>Client::$system->getUserLimit()
		]);
		
		
		if (Client::$viewer->auth()){
			Client::data("focused", 1);
			Client::data("num_notis", Client::$viewer->getCount('notis'));
			Client::data("last_seen_notis", Client::$viewer->getCount('last_seen_notis'));
			Client::data("num_worknotis", Client::$viewer->getCount('worknotis'));
			Client::data("last_seen_worknotis", Client::$viewer->getCount('last_seen_worknotis'));
		
			Client::data("num_messages", Client::$viewer->getCount('messages'));
			Client::data("last_seen_message", Client::$viewer->getCount('last_seen_message'));
			Client::data("learn", OnBoard::release());
		}
		
		if (mobile()){
			Client::data("mobile", 1);
		}
		
		
		bind("system.name", Client::$system->name);
		bind("system.domain", Client::$domain);
		
		
		if (Client::$network){
			bind("network.name", Client::$network->name);
			bind("network.path", Client::$network->path);
		}
		
		
		if (Client::$user){
			bind("user.name", Client::$user->name);
			bind("user.first_name", Client::$user->first_name);
			bind("user.username", Client::$user->username);
			bind("user.path", "@".Client::$user->username);
		}
		
	}

	// For socket.io
	Client::data("secureData",["token"=> Client::$viewer->getSecuredToken(), "session"=> Session::id()]);

?>