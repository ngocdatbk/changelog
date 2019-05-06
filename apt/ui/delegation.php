<?php 

	namespace ui;
	
	class Delegation{
		public static function alert(){
			$user=\Client::$viewer;
			if ($user->onActiveDelegation()){
				$to=$user->getDelegation();
				if ($to){
					echo "<div id='delegation-alert'>
						<div class='icon'></div>
						<div class='txt'>You are on-leave and delegate Request procession to <b>{$to->name}</b> @{$to->username}</div>
						<div class='cta' onclick='Me.delegate()'>Edit now</div>
					</div>";
				}
			}
		}
	}

?>