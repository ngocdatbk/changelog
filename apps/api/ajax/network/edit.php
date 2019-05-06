<?php 

	$network=new Network(HTML::inputInt('network'));
	
	this\requireAdmin($network);
	
	$network->name=HTML::inputInline('name');
	$network->data->about=HTML::inputSimple('about');
	
	if (Word::isEmpty($network->name)){
		Ajax::release("EMPTY.NAME");
	}
	
	$code=FileDB::upload("image", $network);
	
	if ($code->good()){
		$network->image=$code->message->id();
	}
	
	if (!$network->edit('name, data, image')){
		Ajax::release(Code::DB_ERROR);
	}
	
	$network->unload();
	
	Ajax::extra("network", $network->release());
	$network->unload();
	
	Ajax::release(Code::success());

?>