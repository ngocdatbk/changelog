<script>
	PeopleMng.display(Client.pageData.people);
	$("#people-search-ip").on("input", function(){
		var q=$(this).val();
		PeopleMng.filter(q);
	});

	$("#menu .li").setActiveURL();
</script>




<div class='objtab'> 
	<table id='people-list'>
		<thead>
			<tr>
				<th>Họ &amp; tên</th>
				<th style='width:40px'>&nbsp;</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
