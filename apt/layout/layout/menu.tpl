<script>
	$("#menu .userinfo").html("<div class='name'>"+Client.viewer.name+"</div>"+
			"<div class='info ap-xdot'>@"+Client.viewer.username+" &nbsp;&middot;&nbsp; "+Client.viewer.email+"</div>");
</script>

<div id='menuw'>
	<div id='menu'>
		
		<div class='list items'>
		
			<div class='top'>
				<div class='userinfo ap-xdot'></div>
			</div>
		
			
			<div class='title'>
				{{common.account.title|Thông tin tài khoản}}
			</div>
		
			<div class='box'>
				<div class='li active url' data-url='account'>
					<div class='icon'><span class='-ap icon-gear'></span></div>
					<div class='text'>{{common.account.info|Tài khoản}}</div>
				</div>
				
				<div class='li' onclick='Me.info.edit();'>
					<div class='icon'><span class='-ap icon-pen'></span></div>
					<div class='text'>{{common.edit.account|Chỉnh sửa}}</div>
				</div>
				
				<div class='li' onclick='Me.info.editLanguage();'>
					<div class='icon'><span class='-ap icon-compass2'></span></div>
					<div class='text'>{{common.edit.language|Ngôn ngữ}}</div>
				</div>
				
				
				<div class='li' onclick='Me.info.editPassword();'>
					<div class='icon'><span class='-ap icon-exclamation'></span></div>
					<div class='text'>{{common.edit.password|Đổi mật khẩu}}</div>
				</div>
				
				
				<div class='li' onclick='Me.chooseColor();'>
					<div class='icon'><span class='-ap icon-palette'></span></div>
					<div class='text'>{{common.edit.color|Đổi màu hiển thị}}</div>
				</div>

				<!--
				<div class='li url' data-url='account/devices'>
					<div class='icon'><span class='-ap icon-mobile2'></span></div>
					<div class='text'>{{common.edit.mobile|Thiết bị Mobiles}}</div>
				</div>
				-->
				
				<div class='li url' data-url='2factor'>
					<div class='icon'><span class='-ap icon-lock_outline'></span></div>
					<div class='text'>2-factor authentication</div>
				</div>
				
			</div>

			<?php if (ENV == 0 || \Client::$system->path != "vib"): ?>

			<div class='title'>
				{{common.app.title|Ứng dụng - Bảo mật}}
			</div>
			
			<div class='box'>
				<div class='li url' onclick='Admin.sa.setIPRange()'>
					<div class='icon'><span class='-ap icon-shield'></span></div>
					<div class='text'>{{common.edit.ip|Bảo mật theo dải IP}}</div>
				</div>
				
				<?php if (\this\sysowner()): ?>
				<div class='li url' data-url='tokens'>
					<div class='icon'><span class='-ap icon-share5'></span></div>
					<div class='text'>App access tokens</div>
				</div>
				
				
				<div class='li url' data-url='media'>
					<div class='icon'><span class='-ap icon-image3'></span></div>
					<div class='text'>Logo &amp; Branding</div>
				</div>
				
				<?php endif; ?>
				
				
				<div class='li url' data-url='account/apps' style='display:none'>
					<div class='icon'><span class='-ap icon-dashboard'></span></div>
					<div class='text'>{{common.edit.app|Quản lý ứng dụng}}</div>
				</div>
				
				
				<a class='li' href='//apps.base.vn' target='_blank' style='display:none'>
					<span class='icon'><span class='-ap icon-arrow-right3'></span></span> 
					<span class='text'>{{common.edit.baseapp|Kho ứng dụng Base}}</span>
				</a>
				
				<?php if (\this\sysowner()): ?>
				<div class='li' onclick='Admin.sa.setPrivacy();'>
					<div class='icon'><span class='-ap icon-cog3'></span></div>
					<div class='text'>{{common.view.right|Quyền xem thông tin}}</div>
				</div>
				<?php if (\Client::$system->getLimitType()=="app"):?>
				<div class='li' onclick='Admin.sa.setAppUser();'>
					<div class='icon'><span class='-ap icon-unlock-stroke'></span></div>
					<div class='text'>Config app permission</div>
				</div>
				<?php endif; ?>
				<?php endif; ?>
			</div>

			<?php endif; ?>
			


			<?php if (ENV == 0 || \Client::$system->path != "vib"): ?>

			<div class='title'>
				{{common.edit.advance|Tùy chỉnh nâng cao}}
			</div>
			
			
			<div class='box'>
			
				<div class='li' onclick='Me.delegate();'>
					<div class='icon'><span class='-ap icon-share5'></span></div>
					<div class='text'>On leave - Delegation</div>
				</div>
				
			</div>
			
			<?php endif; ?>

		</div>
		
		
	</div>

</div>