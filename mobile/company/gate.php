<?php 

if (Client::$viewer->isGuest()){
	Action::forward("redirect");
}

?>