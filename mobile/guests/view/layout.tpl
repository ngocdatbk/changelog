<script>
	
	GuestMng.display(Client.pageData.guests);
	$("#people-search-ip").on("input", function(){
		var q=$(this).val();
		PeopleMng.filter(q);
	});

	$("#menu .li").setActiveURL();

	Admin.checkUserQuota();
</script>


{% view @company/header.tpl}


<div id='body' class='with-header-footer'>
	<div id='subheader'>
		<div class='items'>
			<div class='item url' data-url='company'>
				Thành viên
			</div>
			
			<div class='item url' data-xurl='company/units'>
				Đơn vị nghiệp vụ
			</div>
			
			
			<div class='item url active' data-xurl='guests'>
				TK Khách
			</div>
			
		</div>
	</div>


	<div id='quota-alert'></div>

	<div class='objlist' id='people-list'></div>

	
</div>