<?php 

	$action=Action::tail(":first");

	
	if ($action=="get"){
		$file=new \FileBase();
		$file->select("requests.json", CACHE_DIR, "r");
		$str= $file->read();
		
		$str=\Word::split("\n\n", $str);
		foreach ($str as $s){
			$obj=(object) json_decode($s);
			if ($obj && isset($obj->url)){
				echo "<h4>{$obj->url} &mdash; {$obj->since}</h4>";	
				print_r($obj->request);
			}
		}
	}else{
		/**
		 * @desc Log API REQUEST
		 */
		
		$obj=(object)["request"=> $_POST];
		$obj->url=Action::current()->url();
		$obj->since=APT::friendlyDateTime(time());
		
		$obj="\n\n".json_encode($obj);
		
		$file=new \FileBase();
		$file->select("requests.json", CACHE_DIR, "a");
		$file->write($obj);
		$file->__destruct();
		echo "DONE";
		
	}
		
	exit;
	
?>