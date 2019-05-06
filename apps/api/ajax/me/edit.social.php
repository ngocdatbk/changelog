<?php 

	$website=HTML::inputInline("website");
	
	if (Valid::url($website)){
		Client::$viewer->data->website=$website;
	}
	
	$facebook=HTML::inputInline("facebook");
	
	if (Valid::username($facebook)){
		$facebook="https://www.facebook.com/".$facebook;
	}
	
	if (Valid::url($facebook)){
		Client::$viewer->data->facebook=$facebook;
	}
	
	
	$twitter=HTML::inputInline("twitter");
	
	if (Valid::username($twitter)){
		$twitter="https://www.twitter.com/".$twitter;
	}
	if (Valid::url($twitter)){
		Client::$viewer->data->twitter=$twitter;
	}
	
	
	$linkedin=HTML::inputInline("linkedin");
	
	if (Valid::url($linkedin)){
		Client::$viewer->data->linkedin=$linkedin;
	}
	
	
	$skype=HTML::inputInline("skype");
	
	if (Valid::username($skype)){
		Client::$viewer->data->skype=$skype;
	}
	
	if (!Client::$viewer->edit('data')){
		Ajax::release(Code::DB_ERROR);
	}
	
	Ajax::release(Code::success());

?>