<?php $user=get("user"); ?>

<div id='auth'>

	<div class='box-wrap'>
	
		<div class='auth-logo'><img src='{% share_url}/<?php echo (strpos(strtolower(SITENAME), "base") !== false) ? "base" : strtolower(SITENAME);?>/logo2.png' /></div>
		<div class='auth-sub-title'>Welcome back. Create an account to start working with your team.</div>
	
		
		<div class='box'>
		
			<div class='form'><form method='post' id='authform' action='a/join'>
			
				<?php hidden("time", HTML::get("time"));?>
				<?php hidden("token", HTML::get("token"));?>
			
				<div class='row'>
					<div class='label'>Your email</div>
					<div class='input disabled'><input type='text' name='email' placeholder='Your email' value='<?php echo HTML::get("email");?>'></div>
				</div>
				
				
				<div class='row'>
					<div class='label'>Your {% const SITENAME} username</div>
					<div class='input-adv'>
						<span class='pretext'>@</span><input type='text' name='username' placeholder='Your username' value='<?php echo $user->username;?>'>
					</div>
					
					<div class='info red' style='padding-top:10px;'>The username <b>cannot</b> be changed, so please choose a good one for you.</div>
				</div>
				
				
				<div class='row'>
					<div class='label'>Your name</div>
					<div class='input-group xo'>
						<div class='input left half'><input type='text' name='first_name' placeholder='Your first name' value='<?php echo $user->first_name?>'></div>
						<div class='input right half'><input type='text' name='last_name' placeholder='Your last name'  value='<?php echo $user->last_name?>'></div>
					</div>
				</div>
				
				
				
				<div class='row relative xo'>
				
					<div class='submit' onclick='W.account.join(this);'>Join to start working</div>
				
				</div>
				
			</form></div>
			
			
			
			<div class='extra xo'>
			
				<div class='simple'>&copy; {% const SITENAME} &middot; The Communication and Collaboration Platform for Enterprises</div>
				
			</div>
			
			
		
		</div>
	
	</div>


</div>