{% VIEW js.startup}

{% START}
	<NOSCRIPT><div class='noscript'><br><br>Javascript must be enabled to process the website.</div></NOSCRIPT>
	
	<div id='sgate'>
		
		<h1>Wideframe<span> &middot; Base Apps</span></h1>
		{%msg}
		<?php
			hidden('auth-name','sauth','auth-name');
		?>
		<div class='input'><input name='password' type='password' placeholder="→ Enter password and press enter to start discovering"/></div>
	</div>
	
	<div id='bcanvas'>
		<div class='__content'></div>
	</div>
	
	<div id='fb-root'></div>
	
	<div id='broot'></div>
	<div id='droot'></div>
	
	<?php if(!onpremise()) { EStat::googleNew("UA-28742893-7",DOMAIN, false); } ?>

	
	<script>
		$("#sgate input").focus();
		$("#sgate input[name=password]").enter(function(){
			var val=$(this).val();
			var name=$('#auth-name').val();
			if (!AP.word.empty(val) && AP.word.safeChar(val)){
				$.cookie(name,val,{expires:300000, domain: Client.domain});
				AP.refresh();
			}
		});
		$("html").addClass("dark");
	</script>