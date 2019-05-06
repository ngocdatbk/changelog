{% VIEW js.startup}

{% START}
	<NOSCRIPT><div class='noscript'><br><br>Javascript must be enabled to process the website.</div></NOSCRIPT>
	
	<div id='ptransit'></div>
	
	{% view [GTEMPLATE]/base.tpl}
	
	{% view mlayout/drawer.tpl}
	{% view mlayout/sidebar.tpl}
	
	<div id='document'>	
		<div id='page'>
			{% view %mainapp}
			{% view %sideapp}
		</div>
		
	</div>
	
	
	<?php if(!onpremise()) { EStat::googleNew(\base\Checkpoint::ga(),"auto"); } ?>
	
	<script>
		$(".url").live('click',function(){
			urlClick(this);
		});

		$(".actionable").live('click',function(){
			var action = $(this).data('actionable');
			action();
		});
		
		Layout.init();
		M.init();

		Client.focused=true;
		$(window).focus(function(){
			Client.focused=true;
		});

		$(window).blur(function(){
			Client.focused=false; 
		});

	</script>