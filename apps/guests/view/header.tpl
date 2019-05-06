<script>
	$("#base-panel .item").setActiveURL("guests");
	$("#mngheader .tab").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	<?php if (\this\sysadmin()):?>
		<div class="cta" onclick="Guest.addAccount({}, 'account');">Thêm TK khách hàng</div>
	<?php endif;?>
			
	<div class="menu clear-fix">
		<div class="tab tab-everyone url" data-url='guests'>Active <span class='counter'></span><span class="r"></span></div>
		<div class="tab tab-deactivated url"  data-url='guests/deactivated'>Deactivated <span class='counter'></span><span class="r"></span></div>
	</div>
	
	<div class='search'>
		<div class='input'>
			<input type='text' placeholder='Tìm kiếm tài khoản' id='people-search-ip'/>
		</div>
	</div>
		
</div>