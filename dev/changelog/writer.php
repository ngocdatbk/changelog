<?php 
	
	namespace changelog;
	
	class Writer extends \Asset{
		public static $db="writer";
		public static $schema="
			id int,
			user_id int,
			product_id int,
		";
	}

?>