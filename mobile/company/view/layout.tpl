<script>
	if (Client.quota_alert){
		$("#quota-alert").html("<div class='box'>Số lượng tài khoản trên hệ thống đã/sắp vượt qua giới hạn (<b>"+Client.quota_alert.limit+"</b>)</div>");
	}
</script>

{% view ~header.tpl}

<div id='body' class='with-header-footer'>
	<div id='subheader'>
		<div class='items'>
			<div class='item url active' data-url='company'>
				Thành viên
			</div>
			
			<div class='item url' data-xurl='company/units'>
				Đơn vị nghiệp vụ
			</div>
			
			
			<div class='item url' data-xurl='company/units'>
				TK Khách
			</div>
			
		</div>
	</div>


	<div id='quota-alert'></div>

	
	{% view ~people.tpl}

	
</div>

<?php if (\this\sysadmin()): ?>
<div id="fba" data-sticky="1" class="" onclick="Admin.createAccount();">
	<div class="-ap icon-add"></div>
</div>
<?php endif; ?>