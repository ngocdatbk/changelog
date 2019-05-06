<div id='auth' class='auth'>

	<div class='box-wrap'>
	
		<div class='auth-logo'><a href='https://{% const DOMAIN}'><img src='{% share_url}/brand/logo.full.png' /></a></div>
	
				
		<div class='box'>

			<h1>Setup the first system</h1>
			<div class='auth-sub-title'>Setup the first system in Base platform</div>
			
			
			<div class='form'><form method='post' id='authform' action='a/setup'>
			
				<?php hidden("time", HTML::get("time"));?>
				<?php hidden("token", HTML::get("token"));?>
			
				<div class='row'>
					<div class='label'>Your email</div>
					<div class='input disabled'><input type='text' name='email' placeholder='Your email' value='<?php echo HTML::get("confirm");?>'></div>
				</div>
				
				
				<div class='row'>
					<div class='label'>Your password</div>
					<div class='input'><input type='password' name='password' placeholder='Your password'></div>
				</div>
				
				
				<div class='row'>
					<div class='label'>Your username</div>
					<div class='input-adv'>
						<span class='pretext'>@</span><input type='text' name='username' placeholder='Your username'>
					</div>
				</div>
				
				
				<div class='row'>
					<div class='label'>Your name</div>
					<div class='input'><input type='text' name='name' placeholder='Your name'></div>
				</div>
				
				
				
				<div class='row'>
				
					<div class='label'>Your company</div>
					<div class='input'><input type='text' name='company' placeholder='Name of your company' value='<?php echo HTML::get("company");?>'></div>				
				</div>
		
		
				<div class='row'>
					<div class='label'>
						Company path
						<span class='right sub normal'>This is important and cannot be changed</span>
					</div>
					
					<div class='input-adv relative'>
						<span class='pull-right subtext' style='padding:8px;'>.{% const DOMAIN}</span>
						<span class='pretext'>www.</span><input type='text' name='path' placeholder='some sub-domain'>
					</div>
				</div>
				
				
				<div class='row relative xo'>
									
					<div class='submit' onclick='Account.setup(this);'>Setup the system now</div>
				
				</div>
				
			
			</form></div>
			
			
			
			<div class='extra xo'>
			
				<div class='simple'><a href='{% root}/a/login' class='std'>Login now</a> if your company was already setup</div>
				
			</div>
			
			
		
		</div>
	
	</div>


</div>