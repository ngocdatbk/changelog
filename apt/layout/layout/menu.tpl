<script>
	$("#base-panel .item").setActiveURL("account");
	$("#menu .li").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	<div class="left" style="float: right">
		<div class="url" onclick='Changelog.create();' style="float: right; padding: 10px 20px; font: 20px"><span class='-ap icon-arrow_upward'></span> &nbsp; New product</div>

		<div class="url" onclick="Changelog.filterSubscribed(true);" style="float: right; padding: 10px 20px; font: 20px">I subscribed</div>

		<div class="url" onclick="Changelog.filterSubscribed(false);" style="float: right; padding: 10px 20px; font: 20px">All</div>
	</div>



	<div class='search'>
		<div class='input'>
			<input type='text' placeholder='Tìm kiếm product' id='product-search-ip'/>
		</div>
	</div>
		
</div>