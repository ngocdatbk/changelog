<?php

	/** 
	* Final Class: Ajax
	 -----------------------------------
	 
		@author Hung Pham
		@contact hung@cs.stanford.edu, Stanford University
		@since June 16, 2010
		@copyright Youclever Project
		
		--------------------------------
		
		@desc  This class will be used to handle all Ajax request. An object named
		$ajax will be created automatically.
		
	*/
	
	final class Ajax extends APAjax{
		public static function init(){
			self::$__autoload_user=false;
			parent::init();
			Client::initSystem();

			// Autoload for AJAX request
			if (Action::$mode==Action::AJAX){
				// Getting the network
				
			}
		}
	}
?>