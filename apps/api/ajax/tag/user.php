<?php 

	$q=HTML::inputInline("q");
	
	if (!Word::isEmpty($q) && strlen($q)){
		if ($q{0}=='@'){
			$q=substr($q,1);
		}
		$users=User::find("username like '%$q%' and system_id='".Client::$system->id."'");
		
		Ajax::autoComplete($users, function($u){
			return ["id"=>$u->username, "name"=>$u->name." &middot; ".notEmpty($u->title, "<em>No official title</em>"), "value"=>"@".$u->username, "gavatar"=>User::avatar($u->username), "sub"=>$u->name];
		});
	}

?>