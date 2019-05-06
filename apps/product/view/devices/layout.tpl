<script>
	NetworkMng.display(Client.units);
	$("#network-search-ip").on("input", function(){
		var q=$(this).val();
		NetworkMng.filter(q);
	});
	
</script>


<?php if(strpos(strtolower(SITENAME), "base") !== false): ?>
{% view layout/menu.tpl}
<?php else: ?>
{% view layout/menu.teamup.tpl}
<?php endif; ?>

<div id='page-main'>
	{% view ~devices/header.tpl}
	<div class='objlist' id='network-list'></div>
</div>