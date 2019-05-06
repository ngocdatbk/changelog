<?php 
	
	/**
	 * @var Resource $obj
	 */
	$obj=getObject(HTML::inputInline("hid"));
	
	if (!$obj || !$obj->good() || !$obj->tokenMatched()){
		Ajax::release(Code::INVALID_DATA);
	}

	if (!$obj->is('topic\Topic') && !$obj->is('meeting\Meeting')){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if (!$obj->viewable(Client::$viewer)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	// Save the poll
	$poll=\survey\Poll::quickCreate($obj); 
	
	if ($obj->is('\topic\Topic')){
		$post=Post::createLog($poll, $obj, Client::$viewer);
		Ajax::extra("post", $post->release());
		
		Update::triggerAction($obj);
	}
	
	
	$obj->onPoll($poll);
	
	Ajax::extra("poll", $poll->release());
	Ajax::release(Code::success());
	
?>