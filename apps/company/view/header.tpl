<script>

	if ($("#js-dnd-upload").length){
		AP.uploadable("#js-dnd-upload", {
			multi: false,
			name: "file",
			action: "api/company/account/dnd",
			data: {}
		}, function(code){
			AP.xRefresh();
		});
	}

	$("#base-panel .item").setActiveURL("company");
</script>


<div class="apptitle" id="mngheader">
	<?php if (\this\sysadmin()):?>
		<div class="cta -dd">
			Thêm thành viên &nbsp; <span class='-ap icon-chevron-down2'></span>
			
			<div class='dd'>
				<div class='item' onclick="Admin.createAccount();">{{account.acc.create|Tạo tài khoản trực tiếp}}</div>
				<div class='item url' data-url=':export'>{{account.acc.exp|Export danh sách ra Excel}}</div>
				<div class='item' id='js-dnd-upload'>{{account.acc.imp|Upload danh sách tài khoản từ Excel}}</div>
				<div class='item' style='display:none' onclick="Company.invite();">{{account.acc.invite|Mời thành viên qua Email}}</div>
				
				<div class='sep'></div>
				
				<a class='item url' target='_blank' href='{% root}/resources/users.xsl'>{{account.sample|Xem file excel mẫu}}</a>
			</div>
		</div>
		
	<?php endif;?>
			
	<div class="menu clear-fix">
		<div class="tab tab-everyone active" data-tab='all' onclick="PeopleMng.show('everyone');">{{account.all|Tất cả}} <span class='counter'></span>/<b class='red'><?php echo \Client::$system->getUserLimit(); ?></b>)<span class="r"></span></div>
		<div class="tab -stroked tab-admins" data-tab='admins' onclick="PeopleMng.show('admins');">{{account.admin|Quản trị}} <span class='counter'></span><span class="r"></span></div>
		<div class="tab -stroked tab-online" data-tab='online' onclick="PeopleMng.show('online');">{{account.online|Đang online}} <span class='counter'></span><span class="r"></span></div>
		
		<?php if (\this\sysowner()):?>
		<div class="tab -stroked tab-deactivated url" data-url='company/deactivated'>Deactivated <span class='counter'></span><span class="r"></span></div>
		<?php endif; ?>
	</div>
	
	<div class='search'>
		<div class='input'>
			<input type='text' placeholder='Tìm kiếm thành viên' id='people-search-ip'/>
		</div>
	</div>
		
</div>