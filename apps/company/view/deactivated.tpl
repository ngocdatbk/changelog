<script>
	PeopleMng.displayDeactivated(Client.pageData.people);
	$("#people-search-ip").on("input", function(){
		var q=$(this).val();
		PeopleMng.filter(q);
	});

	Admin.checkUserQuota();
</script>


{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~header.tpl}
	
	<div id='quota-alert'></div>
	
	<div class='objtab'> 
		<table id='people-list'>
			<thead>
				<tr>
					<th>{{common.name|Họ-tên}}</th>
					<th style='width:25%'>{{common.contact|Thông tin liên lạc}}</th>
					<th style='width:25%'>{{common.manager|Người quản lý}}</th>
					<th style='width:50px'>&nbsp;</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	
</div>