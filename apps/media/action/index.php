<?php 

	layout("mainapp", "~layout.tpl");
	
	$obj=Client::$system->data->getObject("media");
	foreach ($obj as $k=>$v){
		$obj->{$k}=\FileDB::link($v);
	}
	
	Client::pageData("media", $obj);

?>