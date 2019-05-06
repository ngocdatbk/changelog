<script>
	$("#base-panel .-user-avatar").html("<div class='inner'><img src='"+AP.xthumb(Client.viewer.gavatar)+"?ts="+AP.time.now()+"'></div>");
	$("#base-apps").addClass("ext");
	
</script>

<div id='base-panel' class='ext -more'>	
	<div class='items'>
		<div class='item' onclick="Base.open('apps');">
			<div class='image -user-avatar'></div>
		</div>
		
		
		<?php if (\this\sysadmin()):?>
		
		<div class='item item-add' onclick="Admin.createAccount();">
			<div class='icon'>
				<span class='-ap icon-add'></span>
				<span class='r'></span>
			</div>

			<div class='info'>{{common.left.account|Tài khoản}}</div>
		</div>
		
		<?php endif; ?>
		
		<div class='item active item-main url' title='Tài khoản' data-url='account'>
			<div class='icon'>
				<span class='-ap icon-account_circle'></span>
				<span class='r'></span>
			</div>
			
			<div class='info'>{{common.left.personal|Cá nhân}}</div>
			
		</div>
		
		
		<div class='item item-company url' data-url='company'>
			<div class='icon'>
				<span class='-ap icon-users'></span>
				<span class='r'></span>
			</div>
			
			<div class='info'>{{common.left.member|Thành viên}}</div>
		</div>


		<?php if (ENV == 0 || \Client::$system->path != "vib"): ?>

		<div class='item item-chart url' data-url='company/units'>
			<div class='icon'>
				<span class='-ap icon-flow-merge'></span>
				<span class='r'></span>
			</div>
			
			<div class='info'>{{common.left.groups|Nhóm}}</div>
		</div>
		
		
		<div class='item item-guest url' data-url='guests'>
			<div class='icon'>
				<span class='-ap icon-change_history'></span>
				<span class='r'></span>
			</div>
			
			<div class='info'>{{commom.left.guest|TK Khách}}</div>
		</div>
		
		<?php endif; ?>
		
	</div>
	
	
	
	<div class='footer'>
		
		<div class='item' title='Logout' onclick='Base.logout()'>
			<div class='icon'>
				<span class='-ap icon-power_settings_new'></span>
				<span class='r'></span>
			</div>
			<div class='ap-f14' style='margin-top:-5px; padding-bottom:6px;'>Logout</div>
		</div>
		
	</div>
	
	
	
</div>