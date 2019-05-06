<?php 

	/**
	 * @desc Set user password
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	$user=User::withUsername(HTML::inputInline("username"));
	if (!$user || !$user->good()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	if (\this\sysowner($user)){
		Ajax::release("Cannot update password of system owner");
	}

	$password=\HTML::inputInline("password");
	$repassword=\HTML::inputInline("repassword");

	
	if (!\Valid::password($password)){
		Ajax::release("Password is not valid");
	}
	
	if ($password != $repassword){
		Ajax::release("Two passwords are different");
	}
	
		
	$user->password=$user->passwordHash($password);
	$user->edit("password");
	
	// Send email notification
	
	\mail\raw($user->email(), "Your password was changed by ".Client::$viewer->name, "
		<p>Hi, <b>$user->name</b></p>
		<p>This email was sent to tell you that your password on Base platform was recently changed by your system administration.</p>
		<p>The new password is: <b>{$password}</b></p>
		<p>If you have any question, please contact <b>".Client::$viewer->name."</b> (".Client::$viewer->email.") directly.</p>
		<p>Thank you,</p>");
	
	Ajax::release(Code::success());
?>