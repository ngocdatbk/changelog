<?php 
	
	namespace changelog;
	
	class subscriber extends \Asset{
		public static $db="subscriber";
		public static $schema="
			id int,
			user_id int,
			product_id int,
		";
	}

?>