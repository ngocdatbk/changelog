<?php 

	$user=\user\CV::safeInspectUser();

	$key=["office_phone", "home_phone", "skype", "viber", "whatsapp", "zalo"];
	$contact=(object)[];
	
	foreach ($key as $key){
		$contact->{$key}=HTML::inputInline($key);
	}
	
	$user->data->contact=$contact;
	$user->edit("data");
	
	Ajax::release(Code::success());
	

?>