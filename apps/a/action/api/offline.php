<?php 

	$id=HTML::get("id");
	if (Valid::int($id)){
		$user=User::load($id);
		if ($user){
			Online::offline($user->id);
			echo "Success";
			exit;
		}
	}

	echo "Error";
	exit;
?>