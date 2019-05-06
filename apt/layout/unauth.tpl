{% VIEW js.startup}

{% START}
	<NOSCRIPT><div class='noscript'><br><br>Javascript must be enabled to process the website.</div></NOSCRIPT>
	
	<div id='ptransit'></div>
	
	<div id='master' class='wf'><div id='page'>
		{% VIEW %MAIN}
	</div></div>
	
	
	<div id='ajax-load' class='hidden'><div></div></div>
	
	<div id='fb-root'></div>
	
	<div id='broot'></div>
	<div id='droot'></div>
	
	<?php if(!onpremise()) { EStat::googleNew(GA_ID,"auto"); } ?>

	<script></script>
	