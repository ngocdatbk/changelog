<?php

	Schema::load('user\CV, changelog\Product:ext, changelog\Writer:ext, changelog\Subscriber:ext');
	
	FileDB::setSize(0, 60, 60);
	FileDB::setSize(1, 160, 160);
	FileDB::setSize(2, 320, FileDB::RELATIVE_SIZE);
	FileDB::setSize(3, 1200, FileDB::RELATIVE_SIZE);
	FileDB::acceptBigImages();


	Email::template(function($content){
		return "<div style='font-family:Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif;font-size:16px;line-height:21px;color:#333'>
					{$content}
					<div style='font-size:11px; color:#aaaaaa; line-height:16px; border-top:2px solid #e5e5e5; padding-top:20px;'>
						".SITENAME." &middot; Base Platform<span style='color:#fff'>".Word::random(2)."</span>
						<br> This email was sent from a notification-only email address that cannot accept incoming email, please do not reply to this message.<span style='color:#fff'>".Word::random(2)."</span>
					   	<br>For questions and help, please contact to us via email <a style='color:#3b5998;text-decoration:none' href='mailto:".SITEEMAIL."' target='_blank'>".SITEEMAIL."</a><span style='color:#fff'>".Word::random(2)."</span>
					</div>
				</div>";
	});
	

	
	require_once ROOT_DIR.'/settings.php';
	require_once ROOT_DIR.'/../server.php';
	
?>