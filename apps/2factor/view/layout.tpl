<script>
	$("#menu .url").setActiveURL();
	TwoFactor.init();
</script>

{% view layout/menu.tpl}

<div id='page-main'>
	<div id='m_2factor'>
	
		<div class='box'>
			
			<div class='header'>
				<h1>2-factor authentication</h1>
				
				<div class='status'>
					<select name='status' id='js-2factor-status'>
						<option value='0'>Disabled</option>
						<option value='1'>Enabled</option>
					</select>
				</div>
				
				
				<div class='subtitle'>
					2-factor authentication adds an extra layer of security when login. You will probably need Google Authenticator app on your mobile
					to securely store your token (scan the QR code below).
				</div>
			</div>
			
			<?php if (get("qr")): ?>
			<div class='body hidden'>
				<div class='help'>
					Scan the QR code (with Google Authenticator)
				</div>
				
				<div class='qr'><img src='<?php echo get("qr");?>'></div>
				
			</div>
			
			<?php endif; ?>
			
			
			<div id='js-code-verify' class='code-verify hidden'>
				<div class='input'>
					<input type='text' placeholder='06 digit code' name='code-verify'/>
				</div>
				
				<div class='save' onclick='TwoFactor.activate()'>Confirm &amp; activate two-factor</div>
				
			</div>
			
		</div>
	
	
	</div>
</div>