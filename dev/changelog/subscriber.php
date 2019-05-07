<?php 
	
	namespace changelog;
	
	class Subscriber extends \Asset{
		public static $db="Subscriber";
		public static $schema="
			id int,
			user_id int,
			product_id int,
		";
	}

?>