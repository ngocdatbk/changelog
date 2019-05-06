<?php 
	
	/**
	 * Class: Action
	 * 
	 * @author Hung Pham
	 * @since May 19, 2010
	 * 
	 * @desc This is the action controller. Remember: there is only one action
	 * controller throughout any request. The Action Controller will apply the 
	 * request parameters and find the corresponding action and view. 
	 */
	class Action extends APAction{   
		const MAX_PARAMS_LENGTH=20; 
		
		
		public static function dynamicURL(){
			header("Acess-Control-Allow-Origin: *".DOMAIN);
			
			$host=$_SERVER["HTTP_HOST"];
			$path=Word::split(".", $host);
			
			if (count($path)>=1){
				$p=$path[0];
				if ($host==$p.".".DOMAIN || Valid::username($p)){
					self::getDir($p);
				}else{
					
				}
			}
		}
		
		
		
		
		/**
		 * @desc Override this function to create dynamic dir 
		 * @param String $path
		 * @return AppBase
		 */
		public static function getDir($path){
			return null;
			
			$path=html_entity_decode($path);
			if (Word::prefix($path, '@')){
				$username=safe(substr($path, 1));
				if ($username=="me"){
					Client::$user=Client::$viewer;
				}else{
					$user=User::single("username='$username' and system_id='".Client::$system->id."'");
					if ($user){
						Client::$user=$user;
					}
				}
				
				if (Client::$user){
					Client::pageData("user", Client::$user->release());
					Client::pageData("user_extra", Client::$user->releaseExtra());
				}
				
				return AppBase::inlinePath("user");
			}elseif (Valid::safeChar($path)){
				$system=\wiki\System::single("ns_gid='".sysgid(Client::$viewer)."' and path='{$path}'");
				
				if ($system && $system->good()){
					Client::$context=$system;
					$settings=Client::$context->getSettings("team");
					Client::$context->settings=$settings;
					
					Client::pageData("wikisys", Client::$context->release());
					Client::pageData("wikisetting", $settings->release());
					
					return AppBase::inlinePath("wiki");
				}
				
			}

			
			return null;
		}
		
	}
	
?>