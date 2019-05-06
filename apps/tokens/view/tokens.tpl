<script>
	Admin.token.render(Client.pageData.tokens);
</script>

{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~header.tpl}
	
	<div class='objtab'>
		<table id='js-tokenlist'>
			<thead>
				<tr>
					<th>Application</th>
					<th style='width:350px'>Issued token</th>
					<th style='width:100px'>Issued by</th>
					<th style='width:100px'>&nbsp;</th>
				</tr>
			</thead>
			
			<tbody></tbody>
			
		</table>
	</div>
	
</div>