<?php 

	namespace user;

	class CVReader{
		/**
		 * @desc Get a single row
		 * @param Array $opts
		 */
		public static function read($opts){
			$obj=[]; 
			foreach ($opts as $k=>$v){
				$data=self::readSingle($k, $v);
				if ($data===false){
					return null;
				}
			
				$obj[$k]=$data;
			}
			
			$id=\HTML::inputInline("id");
			if ($id && \Valid::alphaNumStrict($id) && strlen($id)==32){
				$obj["id"]=$id;
			}else{
				if (!isset($obj["id"])){
					$obj["id"]=\Word::random(32);
				}	
			}
			
			return (object) $obj;
		}
		
		
		
		public static function readLink($input){
			$url=\HTML::inputInline($input);
			if (!\Valid::url($url)){
				return null;
			}
			
			return \APT::fullURL($url);
		}
		
		
		private static function readSingle($k, $v){
			$ne=false;
			
			if (\Word::suffix($v, "*")){
				$ne=true;
				$v=substr($v, 0, strlen($v)-1);
			}
			
			$val="";
			
			if ($v=="text"){
				$val=\HTML::inputSimple($k);
			}else{
				$val=\HTML::inputInline($k);
			}
			
			if ($ne && \Word::isEmpty($val)){
				return false;
			}
			
			return $val;
		}
	}
?>