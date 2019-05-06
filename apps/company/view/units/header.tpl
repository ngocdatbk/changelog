<script>
	$("#base-panel .item").setActiveURL("company/units");
	$("#menu .li").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	<?php if (\this\sysadmin()):?>
		<div class="cta" onclick="Admin.createNetwork();">Thêm nhóm</div>
	<?php endif;?>
			
	<div class="menu clear-fix">
		<div class="tab url" data-url="company/units">Tất cả nhóm <span class='counter'></span><span class="r"></span></div>
		<div class="tab url" data-url="company/units?s=mine">Nhóm tôi tham gia <span class='counter'></span><span class="r"></span></div>
		<div class="tab url" style='display:none' data-url="company/chart">Sơ đồ tổ chức</div>
	</div>
	
	<div class='search'>
		<div class='input'>
			<input type='text' placeholder='Tìm nhanh nhóm' id='network-search-ip'/>
		</div>
	</div>
		
</div>