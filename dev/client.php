<?php

	/**
	 * @desc Client object
	 * @author CEO
	 *
	 */

	final class Client extends APClient{

		/**
		 * @var \sys\System
		 */
		public static $system=null;
		
		public static $local=true;
		public static $domain="";
		public static $inited=false;
		public static $context=null;
		
		public static function init(){
			require_once(SYS_DIR."/start.php");
			parent::init();
			self::initSystem();
		}
		
		/**
		 * @desc Get the favourite network
		 */
		public static function initSystem(){
			if (!self::$inited){
				self::$inited=true;
				
				define('DOMAIN', SYS_DOMAIN);
				define('URL', SYS_URL);
			}
			
			return true;
			
			
			if (self::$inited){
				if (!self::$system){
					exit("Invalid System");
				}
				
				return true;
			}
			

			self::$inited=true;
			$domain=Request::getDomain();

			if (Word::suffix($domain, SYS_DOMAIN)){
				$prefix=safe(substr($domain, 0, strlen($domain)-strlen(SYS_DOMAIN)-1));
			
				$system=\sys\System::single("path='$prefix'");
				if ($system){
					self::$domain=$domain;
					self::$local=true;
					self::$system=$system;
					
					define('DOMAIN', SYS_DOMAIN);
					define('URL', "http://".DOMAIN);
					return true;
				}
			}elseif (Valid::domain($domain)){
				$system=\sys\System::single("domain='$domain' and domain_status=1");
				if ($system){
					self::$domain=$domain;
					self::$local=false;
					self::$system=$system;

					define('DOMAIN', $domain);
					define('URL', "http://".$domain);
					
					return true;
				}
			}
			
			
			exit("NO SYSTEM");
			return false;
		}
	}
?>