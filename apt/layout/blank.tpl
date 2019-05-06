{% VIEW js.startup}

{% START}
	<NOSCRIPT><div class='noscript'><br><br>Javascript must be enabled to process the website.</div></NOSCRIPT>
	
	{% view common/loader.tpl}
	
	<div id='master'>
		<div id='main' class='xo'>
			<div id='page'>
				
				{% VIEW %main}
				
			</div>
		</div>
	</div>
	
	<div id='ajax-load' class='hidden'><div>Loading ...</div></div>

	<script>		 
		AP.html.resize(function(){
			handleResize();
		}, true);
	
		$("#master-loader").hide();
		$("#master").css("opacity","1");
	</script>
	
	<?php // EStat::google('UA-28742893-3','appicy.com'); ?>