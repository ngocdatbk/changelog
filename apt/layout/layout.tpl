{% VIEW js.startup} 

{% START}
	  
	
	{% view [GTEMPLATE]/base.tpl}
	  
	{% view layout/base.tpl}
	
	<div id='document'>
		<div id='master'>	
			<div id='pagew' class='scrollable' data-autoscroll='1'>
				<div id='page'>
					{% view %mainapp}
					{% view %sideapp}
				</div>
			</div>
		</div>
		
	</div>
	
	
<script>
	$(".url").live('click',function(){
		urlClick(this);
	});
	
	Layout.init();

	Client.focused=true;
	$(window).focus(function(){
		Client.focused=true;
	});

	$(window).blur(function(){
		Client.focused=false;
	});

</script>