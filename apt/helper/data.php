<?php
	

	
	Client::data("ajax_url",ROOT_URL."/ajax");
	Client::data("base_url","http://".DOMAIN);
	Client::data("static_url",STATIC_URL);
	Client::data("image_url",STATIC_URL."/image");
	Client::data("data_url",DATA_URL);
	Client::data("share_url",SHARE_URL);
	Client::data('url', ROOT_URL);
	Client::data('code',APT::makeCode());
	Client::data('env', ENV);
	Client::data('viewer',Client::$viewer->releaseFull());
	
  
	if (Client::$viewer){
		bind('viewer.id',Client::$viewer->id);
		bind('viewer.name',Client::$viewer->name);
		bind('viewer.username',Client::$viewer->username);
		bind('viewer.title',Client::$viewer->title);
		bind('viewer.path',Client::$viewer->path);
		bind('viewer.link',Client::$viewer->link());
		bind('viewer.email',Client::$viewer->email);
	}
	
	
	bind("share_url", SHARE_URL);
	
	if (Client::$system){
		title(Client::$system->name);
	}else{
		title(CONFIG::data('site', 'name'));
	}

	
	Template::meta('<meta name="google-site-verification" content="H6n0qvxxImzZ9U2PbJlpWCDAwlvafPTDnXvXf2k52zw" />');
	Template::fav(SHARE_URL."/apps/account.png");
	
	
?>