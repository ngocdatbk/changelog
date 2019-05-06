<?php

	if (HTML::get("src") && HTML::get("name")){
		$fid=APT::decrypt(HTML::get("src"));
		if (!$fid){
			exit("INVALID FILE");
		}
		
		$name=Word::purify(variable(HTML::get("name")));
		$dir=FileDB::source($fid);
		if (!$dir){
			exit("INVALID FILE");
		}
		
	}else{
		$file=new \file\File(HTML::get("id"));
		
		if (!$file->good() || $file->getSecuredToken() !=HTML::get("token")){
			exit("INVALID FILE");
		}
		
		if (FileDB::link($file->src)!=HTML::get("key")){
			exit("INVALID FILE 2");
		}
		
		if ($file->metatype!="" && $file->metatype!="upload" && $file->metatype!="local"){
			APT::redirect($file->src);
		}
	
		// Mode Sendfile to rescue:
	
		$dir=FileDB::source($file->src);
		if (!$dir){
			exit("INVALID FILE");
		}
		
		$name=$file->name;
	}

	$dir=Word::fixDir($dir);
	
	
	
	header("X-Sendfile: ".$dir);
	// header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"$name\"");
	exit;
?>