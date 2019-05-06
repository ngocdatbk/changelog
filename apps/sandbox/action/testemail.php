<?php
$email = \HTML::get("email");

$engine = \HTML::get("engine");
if($engine == "CUSTOM_SMTP") {
	\Email::engine(\Email::CUSTOM_SMTP);
} else if($engine == "SENDGRID") {
	\Email::engine(\Email::SENDGRID);
} else if($engine == "MAILGUN") {
	\Email::engine(\Email::MAILGUN);
} else if($engine == "SENDGRIDV3") {
	\Email::engine(\Email::SENDGRIDV3);
} else if($engine == "MANDRILL") {
	\Email::engine(\Email::MANDRILL);
}

$from = \HTML::get("from");

if(!$from) {
	$from =  CONFIG::data("SITE", "email");
}

\mail\raw($email, "Test email from " . SITENAME, "
				<p>This email was sent to you for testing</p>
				<p>Test email was sent from IP ".\APT::ip()."</p>", $from);

echo "DONE!";
exit();
?>