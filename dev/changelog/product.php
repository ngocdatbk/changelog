<?php 
	
	namespace changelog;
	
	class Product extends \DB{
		public static $db="product";
		public static $schema="
			id int,
			name varchar(200),
			current_version char(10),
			
			user_id int,
			username varchar(32),
			
			system_id int,
			
			since int:now,
			last_update int:now
		";

        public function user(&$user){
            $this->user_id=$user->id;
            $this->username=$user->username;
            $this->user=$user;
        }

        public function system(&$sys){
            $this->system_id=$sys->id;
            $this->system=$sys;
        }

        public function addWriter(&$user){
            $writer=new Writer();
            $writer->user_id = $user->id;
            $writer->product_id = $this->id;

            if (!$writer->save()){
                return false;
            }
            return true;
        }
	}

?>