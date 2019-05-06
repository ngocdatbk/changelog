<?php 
	
	namespace user;
	
	class CV extends \Asset{
		public static $db="UserCVs";
		public static $schema="
			id int,
			user_id int,
			data object,
			links object,
			extra object,
			token random(32),
			last_update int:now,
			since int:now
		";
		
		
		public static function safeInspectUser(){
			$user=\Client::$viewer;
			if (\HTML::inputInt("id") && \this\sysadmin()){
				$user=new \User(\HTML::inputInt("id"));
				if (!$user->good() || !$user->sysLocal()){
					\Ajax::release(\Code::INVALID_DATA);
				}
			}
			return $user;
		}
		
		
		public static function init($user){
			$obj=new static;
			$obj->user_id=$user->id;
			$obj->connectBy("user_id");
			
			if ($obj->good()){
				return $obj;
			}
			
			$temp=new static;
			
			$temp->user($user);
			if (!$temp->save()){
				return null;
			}
			
			return $temp;
		}
		
		
		public function add($key, $row){
			$arr=$this->data->get($key);
			if (!$arr){
				$arr=[];
			}
			
			$found=false;
			
			for ($i=0; $i<count($arr); $i++){
				if ($arr[$i]->id==$row->id){
					$found=true;
					$arr[$i]=$row;
					break;
				}
			}
			
			if (!$found){
				$arr[]=$row;
			}
			
			$this->data->{$key}=$arr;
		}
		
		
		public function get($key){
			$arr=$this->data->get($key);
			if (!$arr){
				$arr=[];
			}
			
			return $arr;
		}
		
		
		
		public function move($type, $id, $dir){
			$arr=$this->data->get($type);
			if (!$arr){
				return;
			}
			
			if ($dir=="down"){
				$arr=\ARR::moveNext($arr, $id, function($elem, $idx){
					if ($elem->id==$idx){
						return true;
					}
					
					return false;
				});
			}else{
				$arr=\ARR::movePrev($arr, $id, function($elem, $idx){
					if ($elem->id==$idx){
						return true;
					}
						
					return false;
				});
			}
			
			$this->data->{$type}=$arr;
		}
		
		
		public function remove($type, $id){
			$arr=$this->data->get($type);
			if (!$arr){
				return;
			}
			
			$arr=\ARR::remove($arr, $id, function($elem, $idx){
				if ($elem->id==$idx){
					return true;
				}
					
				return false;
			});
			
			$this->data->{$type}=$arr;
		}
		
		
		public function display($row, $key, $df=""){
			if (isset($row->{$key})){
				return $row->{$key};
			}
			
			return $df;
		}
		
		
		
		
		public function setLink($key, $url){
			if (!\Valid::url($url)){
				$this->links->{$key}="";
				return false;
			}
			
			$this->links->{$key}=$url;
			return true;
		}
		
		public function getLink($key){
			$url=$this->links->get($key);
			if (!$url){
				return null;
			}
			
			return $url;
		}
		
		
		public static function read($opt){
			return CVReader::read($opt);
		}
		
		public static function readLink($input){
			return CVReader::readLink($input);
		}
	}

?>