var Layout= new function __Layout(){
	this.init=function(){
		$(document.body).delegate("input","blur", function(){
			setTimeout(function(){
				$("#context-tag > .tags").hide();
			},200);
		}).on("click", function(){
			setTimeout(function(){
				$("#context-tag > .tags").hide();
			},200);
		});
		
		Layout.scrollable('.scrollable');
		
		$(window).blur(function(){
			AP.fire("PAGE.UNFOCUS");
		});
		
		$(window).focus(function(){
			AP.fire("PAGE.FOCUS");
		});
		
		$("#pagescroll > .scrollin").on("scroll", function(){
			var h=$(this)[0].scrollHeight-$(this).scrollTop()-$(this).outerHeight();
			if (h<=50){
				AP.fire("PAGE.OVERSCROLL");
			}
			
			AP.fire("PAGE.SCROLL", [$(this).scrollTop(), $(this)[0].scrollHeight]);
		});
		
		AP.html.resize(function(){
			Layout.checkWidth();
		}, true);
		
		
		AP.sys.fire("system.init");
	};
	
	
	this.checkWidth=function(){
		$("#document").removeClass();
		
		if ($(window).width()<1100){
			$("#document").addClass("screen-ld");
		}else if ($(window).width()<1280){
			$("#document").addClass("screen-md");
		}else if ($(window).width()<1500){
			$("#document").addClass("screen-sd");
		}else{
			$("#document").addClass("screen-hd");
		}
		
	};
	
	
	this.start=function(){
		Layout.scrollable('.scrollable');
		$("#page").removeClass();
		
		this.checkWidth();
		$("#document").removeClass('extented');
		
				
		// this.startCountdown("#document");
		
//		AP.html.resize(function(){
//			if ($("#page .display.-double").length){
//				$("#page .display.-double").css("min-height", $(window).height()-48);
//				var w=$("#page").width();
//				if (w>1370){
//					$("#page .display.-double").addClass("-equal");
//				}else{
//					$("#page .display.-double").removeClass("-equal");
//				}	
//			}
//		});
		
		AP.sys.fire("system.start");
		
		if (Client.pageData.capp && Client.pageData.capp.length){
			Clog.log('capp', safe(Client.pageData.capp));
		}else{
			if (Client.path.app!="welcome"){
				Clog.log('capp', '');	
			}
		}
	};
	
	
	
	this.setColor=function(color){
		$("#document").removeClass().addClass("document-"+color);
	};
	
	
	this.scrollable=function(box){
		if (Client.native){
			return;
		}
		
		$(box).each(function(){
			if ($(this).hasClass('__set')){
				return;
			}
			
			
			$(this).addClass('__set');
			$(this).wrapInner("<div class='scrollin absolute'></div>");
			$(this).find(".scrollin").css({"right":-$.sbWidth(), top:0, left:0, bottom:0});
			AP.scrollBar($(this).find('.scrollin')).init();
		});
	};
	
	
	this.updateScroll=function(canvas){
		if (Client.native){
			return;
		}
		
		$(canvas).find(".scrollin").each(function(){
			$(this).css({"right":-$.sbWidth(), top:0, left:0, bottom:0});
			$(this).scroll();
		});
	};
	
	
	this.scrollDown=function(box){
		var h=$(".__apscrollbar_wrap", box).height();
		$(".scrollin", box).animate({scrollTop: h}, 1000);
	};
	
	this.scrollTo=function(box, offset, anim_time){
		if (!offset){
			offset=0;
		}
		if (typeof anim_time=="undefined"){
			anim_time=500;
		}
		
		var $box=$(box);
		if (!$box.length){
			return;
		}
		
		var $p=$box.closest('.scrollin');
		var h=$box.position().top;
		$p.animate({scrollTop: h-offset}, anim_time);
	};

	
	
	this.scrollTop=function(box){
		if (!box){
			$("#pagescroll > .scrollin").animate({scrollTop: 0}, 500);
			return;
		}
		var $p=$(box).closest('.scrollin');
		$p.animate({scrollTop: 0}, 500);
	};
	
	
	this.hideSide=function(){
		$('#appdialog').hide();
	};
	
	
	this.bcanvas=function(){
		$('#appdialog').hide();
		$("#bcanvas").show();
		$("#bcanvas .full").hide();
		// $("#bside").css("height", $("#bside").parent().height());
		Layout.updateScroll("#bcanvas");
	};
};