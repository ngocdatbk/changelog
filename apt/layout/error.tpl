{% FN Document::init}
{% VIEW js.startup}

{% START}

	
	<div id='master'>
		<NOSCRIPT id='noscript'><div class='noscript'>{{commom.error|Bạn cần bật Javascript để trang web hoạt động}}</div></NOSCRIPT>
		{% VIEW %header}
		
		<div id='page' style='padding-left:0px'>
			<div id='pageerror'>
				{% error.msg}
				
				<div class='back'><a class='std' href='{% root}/home'>Back to <b>{% system.name}</b></a></div>
			</div>
		</div>
		
		{% view %footer}
		
	</div>
	
	<div id='ajax-load' class='hidden'><div><div>Loading ...</div></div></div>

	
	<script>
		AP.fire("page.ajax.end");
	
		AP.html.resize(function(){
			$("#master").css("left",0);
			$("#pageerror").css("min-height", $(window).height());
		}, true);
		documentInit();
	</script>
	