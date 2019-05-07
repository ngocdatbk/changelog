<?php 

	if (Client::$viewer->isGuest()){
		Action::forward("redirect");
	}


	layout("mainapp", "~layout.tpl");
	btitle(Client::$viewer->name, "Changelog");
    $system = Client::$system;
    $products= \changelog\Product::find("system_id='{$system->id}'", "*");

    Client::pageData("products", ARR::select($products, function(&$p){
        return $p->release();
    }));
?>