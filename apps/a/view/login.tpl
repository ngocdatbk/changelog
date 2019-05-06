<div id='auth' class='scrollable' data-autoscroll='1' data-autohide='1'>

	<div class='box-wrap'>
		<div class='auth-logo'><a href='https://{% const DOMAIN}'><img src='{% share_url}/brand/logo.full.png' /></a></div>
		
		
		<div class='box'><form id='authform' action='a/login' method='post'>
			
			<h1>Login</h1>
			<div class='auth-sub-title'>Welcome back. Login to start working.</div>
			
			<div class='form'>
			
				<div class='row'>
				
					<div class='label'>Email</div>
					<div class='input'><input type='text' name='email' placeholder='Your email'></div>
				
				</div>
				
				<div class='row hidden'>
					<div class='input'><input type='hidden' name='appkey'></div>
				</div>
				
				
				<div class='row hidden'>
					<div class='input'><input type='hidden' name='return_path' value='<?php echo base64_encode(\HTML::get("return"));?>'></div>
				</div>
				
				
				<div class='row'>
				
					<div class='label'><span class='a right normal url' data-url='a/recover' onclick="AP.toURL('a/recover');">Forget your password?</span>Password</div>
					<div class='input'><input type='password' id='login-password' name='password' placeholder='Your password'></div>
				
				</div>
				
				<div class='row hidden js-2fa'>
				
					<div class='label'>Two-factor authentication code</div>
					<div class='input'><input type='text' name='code_2fa' placeholder='06 digit code'></div>
				
				</div>
				
				
				
				<div class='row relative xo'>
				
					<div class='checkbox'>
						<input type='checkbox' checked name='saved'> &nbsp; Keep me logged in
					</div>
				
				
					<div class='submit' onclick='Account.login(this);'>Login to start working</div>
				
					<div class='oauth'>
						<div class='label'><span>Or, login via single sign-on</span></div>
						<a class='oauth-login left' href='https://sso.{% const DOMAIN}/google'>Login with Google</a>
						<a class='oauth-login right' href='https://sso.{% const DOMAIN}/ms'>Login with Microsoft</a>
					</div>
				
				</div>
			
			</div>
			
			
			
			<div class='extra xo'>
			
				<div class='simple'>
					<a class='a' href='{% root}/a/guest'>Login with Guest/Client access?</a>
				</div>
				
			</div>
			
			
		
		</form></div>
	
	</div>


</div>



<script>

	$("#login-password").enter(function(){
		Account.login(this);
	});

</script>