<?php 
	
	namespace changelog;
	
	class Product extends \Asset{
		public static $db="Product";
		public static $schema="
			id int,
			name varchar(200),
			current_version char(10),
			
			user_id int,
			username varchar(32),
			
			system_id int:0,
			
			since int:now,
			last_update int
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
	}

?>