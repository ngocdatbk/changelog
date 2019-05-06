<script>
	$("#base-panel .item").setActiveURL("account");
	$("#menu .li").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	
	<div class="cta url" onclick='Product.create();'><span class='-ap icon-arrow_upward'></span> &nbsp; New product</div>
			
	
	<div class='back url' data-url='company'>
		<div class='label'>Tài khoản</div>
		<div class='title'>{% viewer.name} &middot; {% viewer.title}</div>
	</div>
		
</div>