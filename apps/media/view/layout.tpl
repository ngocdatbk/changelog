{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~header.tpl}
	
	
	<div class='objtab'>
		<table id='js-medialist'>
		
			<thead>
				<tr>
					<th>Name</th>
					<th style="width:350px">Preview</th>
					<th style="width:150px">&nbsp;</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<td colspan='4' class='group'>Small logos / icons</td>
				</tr>
				
				<tr class="js-item" data-id="logo_s24" data-name='Solid logo (24px height)'></tr>
				
				<tr class="js-item" data-id="logo_w24" data-name='White logo (24px height)'></tr>
				
				<tr class="js-item" data-id="logo_s32" data-name="Solid logo (32px height)"></tr>
				
				<tr class="js-item" data-id="logo_w32" data-name="White logo (32px height)"></tr>
				
				<tr><td colspan='4' class='group'>Standard logos</td></tr>
				
				<tr class="js-item" data-id="logo_square_s" data-name="Solid square logo (300x300)"></tr>

				<tr class="js-item" data-id="logo_square_w" data-name='Solid white logo (300x300)'></tr>
				
			</tbody>
		
		</table>
	</div>
</div>


<script>
	Admin.media.render(Client.pageData.media);
	setTimeout(function(){
		$("#base-panel .item").setActive(".item-main");
	}, 100);
</script>