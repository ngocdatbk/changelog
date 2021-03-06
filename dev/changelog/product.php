<?php 
	
	namespace changelog;
	
	use ARR;

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

        public function addSubscriber(&$user){
            $writer=new Subscriber();
            $writer->user_id = $user->id;
            $writer->product_id = $this->id;

            if (!$writer->save()){
                return false;
            }
            return true;
        }

        public function release(){
            $writers = $this->releaseWriter();
            $subscribers = $this->releaseSubscriber();

            $num_subscribers = Subscriber::count("product_id='{$this->id}'");

            return (object) [
                "id" => $this->id,
                "name" => $this->name,
                "current_version" => $this->current_version,
                "user_id" => $this->user_id,
                "username" => $this->username,
                "since" => $this->since,
                "last_update" => $this->last_update,
                "system_id" => $this->system_id,
                'writers' => $writers,
                'subscribers' => $subscribers,
                'num_subscribers' => $num_subscribers
            ];
        }

        public function releaseWriter(){
            $writers = Writer::find("product_id='{$this->id}'", "user_id");
            $writers = ARR::select($writers, function(&$p){
                return $p->user_id;
            });
            $writers = \User::withIDs($writers);
            $writers = ARR::select($writers, function(&$p){
                return $p->release();
            });

            return $writers;
        }

        public function releaseSubscriber(){
            $subscribers = Subscriber::find("product_id='{$this->id}'", "user_id");
            $subscribers = ARR::select($subscribers, function(&$p){
                return $p->user_id;
            });
            $subscribers = \User::withIDs($subscribers);
            $subscribers = ARR::select($subscribers, function(&$p){
                return $p->release();
            });

            return $subscribers;
        }

        public static function withName($name){
            return self::single("name='$name'");// and system_id='".Client::$system->id."'
        }
	}

?>