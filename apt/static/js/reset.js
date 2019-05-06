AP.sys.on("page.pre.transition", function(data){
	$("#ptransit").show();
	loadBar("#ptransit", true);
});

AP.sys.on("page.post.transition", function(data){
	setTimeout(function(){
		loadBar("#ptransit", false);
	},500);
	
	Context.hide();
	Context.gen.hide();
});


AP.sys.on("form.pre.submit", function(selector){
	if (Client.pageData.event && Client.pageData.event.id){
		$(selector).append("<input type='hidden' name='__event' value='"+Client.pageData.event.id+"'/>");
	}
});


AP.adaptive=function(u1, u2){	
	return true;
};



/**
 * @desc Reinit document
 */
function documentInit(){
	AP.initPageData();
	Client.title=document.title;
	nsUpdate();
	
	if (!Client.viewer || !Client.viewer.id){
	}else{
		Layout.start();
	}
};



function nsUpdate(){
	if (Client.pageData.user){
		if (!Client.data.user){
			Client.data.user=Client.pageData.user;
			AP.sys.fire("user.changed", Client.data.user, null);
		}else{
			if (Client.data.user.id!=Client.pageData.user.id){
				Client.data.user=Client.pageData.user;
				AP.sys.fire("user.changed", Client.pageData.user, Client.data.user);
			}else{
				Client.data.user=Client.pageData.user;
				AP.sys.fire("user.unchanged", Client.data.user);
			}
		}
		
		// W.log.setAdv('users', {"id":Client.data.user.id, "username": Client.data.user.username, "gavatar": Client.pageData.user.gavatar});
		// W.log.set('networks',-Client.data.user.id);
	}else{
		Client.data.user=null;
	}
	
	
	if (Client.pageData.network){
		if (!Client.data.network){
			Client.data.network=Client.pageData.network;
			AP.sys.fire("network.changed", Client.data.network, null);
		}else{
			if (Client.data.network.id!=Client.pageData.network.id){
				Client.data.network=Client.pageData.network;
				AP.sys.fire("network.changed", Client.pageData.network, Client.data.network);
			}else{
				Client.data.network=Client.pageData.network;
				AP.sys.fire("network.unchanged", Client.data.network);
			}
		}
		
		// W.log.set('networks', Client.data.network.id);
		
		
	}else{
		Client.data.network=null;
		// AP.sys.fire("network.change", network, null);
	}
};



/**
 * @desc Update HTML data to a specific div (selector)
 * @param selector
 * @param data
 */
function ap_update(selector, data){
	$(selector).html(data);
	AP.setContinuousRequest(selector);
	AP.html.init(selector);
};



/**
 * @desc Main RESET and UPDATE
 * @param callback
 */
function reset_page(callback){
	$("#page").children().remove();
	$("#page").empty().html("&nbsp;");
	// Clear lock
	
	AP.__lock=false;
	
	AP.resetPageData();
	AP.sys.fire("page.pre.transition");
	
	if (callback){
		callback();
	}
};

function update_page(data){
	$('#master').removeClass();
	ap_update("#page", data);
	
	window.scrollTo(0,0);
	$("#ap-data").empty();
	
	documentInit();
	
	AP.sys.fire("page.post.transition");
	AP.sys.fire(AP.EVENTS.PAGE_UNLOAD);
	
	
	if (AP.isset('FB')){
		try{
			FB.XFBML.parse(); 
		}catch(ex){};	
	}
};










function loadBar(canvas, status){
	if (!status){
		$(canvas).hide();
		$(canvas).data("lock", false);
		stopBar(canvas, 4)
	}else{
		$(canvas).data("lock", true);
		loadBarAnimation(canvas);
	}
};

function stopBar(canvas, len){
	for (var i=0; i<len; i++){
		$(canvas).find('.bar:eq('+i+') .anim').css({width: 0});			
	}
	
	for (var i=0; i<len; i++){
		$(canvas).find('.bar-'+i).appendTo(canvas);
	}
	
	$(canvas).data("ab",0);
}

function loadBarAnimation(canvas){
	var c=['#F03C32','#09A5E3','FFD726','#08D119'];
	var len=c.length;
	
	if (!$(canvas).data('__bars')){
		for (var i=0; i<len; i++){
			$(canvas).append("<div class='bar bar-"+i+"'><div  style='background-color:"+c[i]+"' class='anim'></div></div>");
		}
	}

	$(canvas).data('__bars',1);
	
	$(canvas).find('.bar:eq(0) .anim').show().css("width","100%");
	$(canvas).data('lock', true);
	$(canvas).show();
	
	animateBar(canvas, len);
};

function animateBar(canvas, len){
	var lock=$(canvas).data("lock");
	if (!lock){
		return;
	}
	
	var index=$(canvas).data("ab");
	if (!index){
		index=0;
	}
	index++;
	
	if (index>=len){
		index=0;
		
		for (var i=0; i<len-1; i++){
			$(canvas).find('.bar:eq('+i+') .anim').css({width: 0});			
		}
		$(canvas).find('.bar:last').prependTo(canvas);
		index++;
	}
	

	$(canvas).data("ab",index)
	$(canvas).find('.bar:eq('+index+') .anim').animate({'width':'100%'},800, function(){
		if (!$(canvas).data("lock")){
			stopBar(canvas, 4);
			return;
		}else{
			animateBar(canvas, len);
		}
	});
};