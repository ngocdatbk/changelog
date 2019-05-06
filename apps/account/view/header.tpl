<script>
	$("#base-panel .item").setActiveURL("account");
	$("#menu .li").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	
	<div class="cta url" onclick='Me.info.edit();'><span class='-ap icon-arrow_upward'></span> &nbsp; {{commom.edit.account|Chỉnh sửa tài khoản}}</div>
			
	
	<div class='back url' data-url='company'>
		<div class='label'>Tài khoản</div>
		<div class='title'>{% viewer.name} &middot; {% viewer.title}</div>
	</div>
		
</div>