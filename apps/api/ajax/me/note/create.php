<?php 

	$obj=new Note(); 
	
	$obj->origin(Client::$viewer);
	$obj->user(Client::$viewer);
	$obj->skey=Client::$viewer->gid();
	
	if (!$obj->color(HTML::inputInt("color"))){
		Ajax::release("INVALID.COLOR");
	}
	
	$obj->name=HTML::inputInline("name");
	$obj->content=HTML::inputSafe("content", HTML::POST, false);
	if (Word::isEmpty($obj->name)){
		Ajax::release("NAME.EMPTY");
	}
	
	
	// Extract link
	$cobj;
	$obj->content=Word::extractURL($obj->content, function($url) use(&$cobj){
		if ($cobj){
			return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
		}
			
		$c=LinkCache::fastDetect($url);
		if ($c){
			$cobj=$c;
		}
		return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
	});
	

	$labels=[];
	$obj->content=Word::extractTag($obj->content, function($label) use(&$labels){
		$label=strtolower($label);
		$labels[]=$label;
		return '<span class="tag">'.$label.'</span>';
	});
	
	if (count($labels)){
		note\Label::addLabels(Client::$viewer, $labels);
		$obj->tags=$labels;
	}
	
	
	if ($cobj){
		$obj->addLink($cobj);
	}
	
	
	if (!$obj->save()){
		Ajax::release(Code::DB_ERROR);
	}
	
	
	Ajax::extra("note", $obj->release());
	
	Ajax::release(Code::success());
	
?>

