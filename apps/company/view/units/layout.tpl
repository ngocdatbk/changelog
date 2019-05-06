<script>
	NetworkMng.display(Client.units);
	$("#network-search-ip").on("input", function(){
		var q=$(this).val();
		NetworkMng.filter(q);
	});


	AP.dnd("#page-main", "api/company/team/dnd", {}, function(code){
		if (!code.good()){
			return AP.alertError(code.message);
		}

		UI.flash("Uploaded successfully");
		AP.refresh();
	}, {
		loading: true,
		accept: "xls, xlsx",
		multi: false
	});

	
</script>


{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~units/header.tpl}
	<div class='objlist' id='network-list'></div>
</div>