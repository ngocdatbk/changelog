<?php 

	/**
	 * @desc Sysfix an image
	 */


	set_time_limit(10000);
	
	syscron(function(){
		User::dbloop(function(User $user){
			/**
			 * @var \User $user
			 */
			
			// 		if (\Word::prefix($user->image, "avatar:")){
			// 			return;
			// 		}
		
			// 		$user->image="avatar:".$user->image;
			// 		$user->edit("image");
			// 		return;
		
			$origin=$user->image;
			if (strpos($origin, "2018") !== false) {
				$origin=str_replace(["ds201805.", "ds201806.", "ds201807.", "ds201808."], ["","","",""], $origin);
				$user->image=$origin;
				$user->edit("image");
				return;
			}
			
			
			$origin=str_replace("avatar:","", $user->image);
			
			
			
			$file=\FileDB::source($origin);
			$name=last(Word::split("/", $file));
		
			$dir=dirname($file);
			if (!file_exists($file)){
				$user->setDefaultAvatar();
				// echo "INVALID: $file\n";
				return;
			}
		
			$dup=str_replace(DATA_DIR, DATA_DIR."/avatar", $file);
			$dup_dir=dirname($dup);
		
			if (!file_exists($dup_dir)){
				mkdir($dup_dir,0777,true);
			}
		
			if (file_exists($dup_dir."/".$name)){
				echo "[DONE{$user->id}]";
				return;
			}
			
			copy($file, $dup_dir."/".$name);
			copy($dir."/0.$name", $dup_dir."/0.".$name);
			copy($dir."/1.$name", $dup_dir."/1.".$name);
			copy($dir."/2.$name", $dup_dir."/2.".$name);
		
		
			$new_avatar="avatar:".$origin;
			print_r([$origin, $name, $file, $dir, $dup, $dup_dir, $new_avatar, \FileDB::link($origin), \FileDB::link($new_avatar)]);
		
			// 		$user->image=$new_avatar;
			// 		$user->edit("image");
			
		}, "system_id='".Client::$system->id."'");
		
	});
	
	
	exit;
?>