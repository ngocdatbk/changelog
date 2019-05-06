<script>
	PeopleMng.display(Client.pageData.people);
	$("#people-search-ip").on("input", function(){
		var q=$(this).val();
		PeopleMng.filter(q);
	});
	
</script>


{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~network/header.tpl}
	
	<div class='objtab'> 
		<table id='people-list'>
			<thead>
				<tr>
					<th>Họ &amp; tên</th>
					<th style='width:25%'>Thông tin liên lạc</th>
					<th style='width:25%'>Người quản lý</th>
					<th style='width:50px'>&nbsp;</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>