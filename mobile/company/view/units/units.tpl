<script>
	NetworkMng.display(Client.units);
	$("#network-search-ip").on("input", function(){
		var q=$(this).val();
		NetworkMng.filter(q);
	});
</script>


<div class='objlist' id='network-list'></div>
