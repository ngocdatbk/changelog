<?php 

	css()
		->more("~layout.css")
		->more(function(){
			if (mobile()){
				return "~mobile.fix.css";
			}
			
			return null;
		})
		->release();
	
	js()->more("~account.js")->release();
		
	Request::init(function(){
		Template::html("unauth.tpl");
	});

	btitle("Account");
	
	
	if (mobile()){
		 // APT::redirect("mobile");
	}
?>