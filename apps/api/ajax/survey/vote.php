<?php 
	
	/**
	 * @var \survey\Survey $survey
	 */
	$survey=getObject(HTML::inputInline("hid"));
	if (!$survey || !$survey->is('\survey\Survey') || !$survey->good() || !$survey->tokenMatched()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	if ($survey->expired()){
		Ajax::release("We are sorry. The poll is expired and cannot accept more votes.");
	}
	
	if (!$survey->isPoll()){
		Ajax::release(Code::INVALID_DATA);
	}

	
	$origin=getExport($survey->origin_export);
	if (!$origin || !$origin->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	if (!$origin->viewable(Client::$viewer)){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$survey->origin=$origin;
	
	if ($survey->voted(Client::$viewer)){
		Ajax::release("You have already voted this.");
	}
	
	// Vote
	$last_answer="";
	
	$survey->addFollower(Client::$viewer);
	$vote=new \survey\Vote();
	$vote->survey($survey);
	$vote->user(Client::$viewer);
	for ($i=0; $i<count($vote->survey->questions); $i++){
		if (!$vote->cast($i)){
			Ajax::release(Code::INVALID_DATA);
		}
		$last_answer=$vote->getVal($i);
	}
	
	
	if (!$vote->voteNow()){
		Ajax::release(Code::DB_ERROR);
	}
	
	
	if ($survey->isPoll()){
		// Poll vote
		// Followup::logger(Client::$viewer, "vote", "{{username}} voted for <b>{$last_answer}</b>")->origin($survey)->skey($survey->gid())->save();
		// Send notification
		
		N::create($survey->hid())
		->type("poll")
		->action("vote")
		->title("@<b>".Client::$viewer->username."</b> voted on your poll <b>{$survey->getName()}</b>")
		->image(User::avatar(Client::$viewer->username))
		->link($survey->getLink())
		->to($survey->getUser(false))
		->except(Client::$viewer)
		->notify()
		->notifyMobiles()
		->save();
		
		
		N::create($survey->hid())
		->type("poll")
		->action("vote")
		->title("@<b>".Client::$viewer->username."</b> voted on the poll <b>".$survey->getName()."</b> that you followed")
		->image(User::avatar(Client::$viewer->username))
		->link($survey->getLink())
		->to(UserList::loadUsernames($survey->followers))
		->except(Client::$viewer)
		->except($survey->getUser())
		->notify()
		->notifyMobiles()
		->save();
		
		
	}else{
		
	}
	
	
	Comment::system(Client::$viewer, $survey, "voted for <b>{$last_answer}</b>",["action"=>"survey.vote"]);
	
	
	Ajax::extra("survey",$survey->release());
	Ajax::release(Code::success());
?>