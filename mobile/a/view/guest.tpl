<div id='auth'>

	<div class='box-wrap'>
		<div class='auth-logo'><img src='{% share_url}/brand/logo.full.png' /></div>
		
		
		<div class='box'><form id='authform' action='a/guest.login' method='post'>
			
			<h1>Customer &amp; Client Login</h1>
			<div class='auth-sub-title'>Enter your credentials to login.</div>
			
			<div class='form'>
			
				<div class='row'>
				
					<div class='label'>Email</div>
					<div class='input'><input type='text' name='email' placeholder='Your email'></div>
				
				</div>
				
				<div class='row hidden'>
					<div class='input'><input type='hidden' name='appkey'></div>
				</div>
				
				
				<div class='row'>
				
					<div class='label'><span class='a right normal url' data-url='a/recover' onclick="AP.toURL('a/guest.recover');">Forget your password?</span>Password</div>
					<div class='input'><input type='password' id='login-password' name='password' placeholder='Your password'></div>
				
				</div>
				
				
				<div class='row'>
				
					<div class='label'>Access point</div>
					<div class='input'><input type='text' name='access' placeholder='Your granted access point'></div>
				
				</div>
				
				
				<div class='row relative xo'>
				
					<div class='checkbox'>
						<input type='checkbox' checked name='saved'> &nbsp; Keep me logged in
					</div>
				
				
					<div class='submit' onclick='Account.login(this);'>Login to start working</div>
				
				</div>
			
			</div>
			
			
			
			<div class='extra xo'>
			
				<div class='simple'>
					<a class='a' href='{% root}/a/login'>Login with regular access?</a>
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