<?php 


	$user=User::withUsername(HTML::inputInline("username"));
	
	if (!$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$subject=HTML::inputInline("name");
	$content=HTML::inputSafe("content", HTML::POST, false);
	
	if (!Word::isEmpty($subject) && !Word::isEmpty($content)){
		mail\user\raw($user->email, Client::$viewer, $subject, $content);
		Ajax::release(Code::success());
	}
	
	Ajax::release(Code::success());

?>