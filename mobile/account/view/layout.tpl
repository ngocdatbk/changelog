{% view ~header.tpl}

<div id='body' class='with-header-footer'>
	<div id='subheader'>
		<div class='items'>
			<div class='item url active' data-url='account'>
				Account
			</div>
			
			<div class='item' onclick='Me.info.edit();'>
				Tùy chỉnh
			</div>
			
			<div class='item' onclick='Me.info.editPassword();'>
				Đổi mật khẩu
			</div>
			
			
		</div>
	</div>


	
	{% view ~profile.tpl}

	
</div>


<script></script>