<script>
	GuestMng.display(Client.pageData.guests);
	$("#people-search-ip").on("input", function(){
		var q=$(this).val();
		PeopleMng.filter(q);
	});

	$("#menu .li").setActiveURL();

	Admin.checkUserQuota();
</script>




{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~header.tpl}
	
	<div id='quota-alert'></div>
	
	<div class='objlist' id='people-list'></div>
</div>