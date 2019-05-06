{% view ~header.tpl}


<div id='body' class='with-header-footer'>

	<div id='auth'>

		<div class='box-wrap'>
		
			<div class='auth-logo'><img src='{% share_url}/brand/logo.full.png' /></div>
				
			<div class='box'>
				
				<h1>Password Recovery</h1>
				<div class='auth-sub-title'>Please enter your information. A password recovery hint will be sent to your email.</div>
						
				<div class='form'><form method='post' id='authform' action='a/recover'>
				
					<div class='row'>
					
						<div class='label'>Email</div>
						<div class='input'><input type='text' name='email' placeholder='Your email'></div>
					
					</div>
					
					
					<div class='row'>
						<div class='label'>Security code</div>
						<div class='data'>
							<div class='input'><input type='text' name='captcha' placeholder='Enter the security code below'></div>
							<br>
							<img class='pointer' title='Click to refresh' src='{% root}/captcha?ts=<?php echo time();?>' onclick='AP.sys.captchaReload(this);'/>
						</div>
					
					</div>
					
					
					<div class='row relative xo'>
						<div class='submit' onclick='Account.recover(this);'>Recover password</div>
					</div>
					
				
				</form></div>
				
				
				
				<div class='extra xo'>
				
					<div class='simple'><a href='{% root}/a/login' class='std'>Login now</a> if your company was already on <b>{% const SITENAME}</b></div>
					
				</div>
				
				
				
			
			</div>
		
		</div>
	
	
	</div>
</div>