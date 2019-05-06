<script>
	NetworkMng.display(Client.units);
	$("#network-search-ip").on("input", function(){
		var q=$(this).val();
		NetworkMng.filter(q);
	});
	
</script>

{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~devices/header.tpl}
	<div class='objlist' id='network-list'></div>
</div>