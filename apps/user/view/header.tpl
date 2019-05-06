<script>
	Base.focus("company");
	$("#menu .li").setActiveURL();
</script>


<div class="apptitle" id="mngheader">
	
	<a class="cta url" href='https://home.{% domain}'><span class='-ap icon-arrow_upward'></span> &nbsp; Quay lại Base</a>
			
	
	<div class='back url' data-url='company'>
		<div class='label'>Tài khoản</div>
		<div class='title'>{{$user->name}} &middot; {{$user->title}}</div>
	</div>
		
</div>