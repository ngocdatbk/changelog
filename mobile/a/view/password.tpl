<div id='auth' class='auth'>

	<div class='box-wrap'>
	
		<div class='auth-logo'><img src='{% share_url}/brand/logo.full.png' /></div>
		<div class='auth-sub-title'>Account password recovery</div>
	
		
		<div class='box'>
		
			<div class='form'><form method='post' id='authform' action='a/password.reset'>
			
				<?php hidden("email", HTML::get("email"));?>
				<?php hidden("state", HTML::get("state"));?> 
				<?php hidden("token", HTML::get("token"));?>
				<?php hidden("time", HTML::get("time"));?>
				
			
				<div class='row'>
				
					<div class='label'>New password</div>
					<div class='input'><input type='password' name='password' placeholder='Your new password'></div>
				
				</div>
				
				
				<div class='row'>
					<div class='label'>Security code</div>
					<div class='data'>
						<div class='input'><input type='text' name='captcha' placeholder='Enter the security code below'></div>
						<br>
						<img src='{% root}/captcha'/>
					</div>
				
				</div>
				
				
				<div class='row relative xo'>
					<div class='submit' onclick='Account.resetPassword(this);'>Reset password</div>
				</div>
				
			
			</form></div>
			
			
			
			<div class='extra xo'>
			
				<div class='simple'><a href='{% root}/a/login' class='std'>Login now</a> if your company was already on <b>WorkTime</b></div>
				
			</div>
			
			
			
		
		</div>
	
	</div>


</div>