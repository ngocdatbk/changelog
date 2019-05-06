<script>
	Base.focus("chart");
	$("#menu .li").setActiveURL();
	$("#mngheader .tab").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	<?php if (\this\sysadmin()):?>
		<div class="cta" onclick="Admin.createNetwork();">{{common.create.team|Thêm nhóm}}</div>
	<?php endif;?>
			
	<div class="menu clear-fix">
		<div class="tab url" data-url="company/units">{{common.edit.teamlist|Đơn vị nghiệp vụ}} <span class='counter'></span><span class="r"></span></div>
		<div class="tab url" data-url="company/units?s=mine">{{common.myteam|Đơn vị tôi tham gia}} <span class='counter'></span><span class="r"></span></div>
		<div class="tab url" data-url="company/chart">{{common.edit.orgchat|Sơ đồ tổ chức}}<span class='r'></span></div>
	</div>
	
	<div class='search'>
		<div class='input'>
			<input type='text' placeholder='{{common.search.team|Tìm kiếm đơn vị nghiệp vụ}}' id='network-search-ip'/>
		</div>
	</div>
		
</div>