var App=new function __App(){
	
	this.title=function(title){
		makeTitle(title);
	};
	
	this.init=function(opts){
		if (AP.data.isArray(opts)){
			this.initArray(opts);
			return this;
		}
		
		if (opts.title){
			makeTitle(opts.title);
		}
		
		if (!opts.key || opts.key=="none"){
			$("#header .key-action").html("").hide();
			$("#header").addClass("-no-key-action");
		}else if (opts.key=="menu"){
			$("#header .key-action").html("" +
				"<span class='-ap icon-menu'></span>" +
				"<div class='-cmenu xo' style='width:300px; top:47px; left:0px;'>" +
				"	<div class='-item url' data-xurl='people'>People<span class='-icon -ap icon-group text-9'></span> </div>" +
				"	<div class='-item url' data-xurl='settings'>Settings<span class='-icon -ap icon-cog3 text-9'></span></div>" +
				"	<div class='-item-sep'></div>" +
				"	<div class='-item' onclick='Company.invite();'>Invite people<span class='-icon -ap icon-person_add text-9'></span> </div>" +
				"	<div class='-item' onclick='Network.integrate();'>Integration<span class='-icon -ap icon-stack4 text-9'></span> </div>" +
			"</div>");
		}else if (opts.key=="back"){
			if (Client.data.network){
				$("#header .key-action").html("<span class='-ap icon-chevron-left2'></span> <span class='txt'>"+Client.data.network.name+"</span>").addClass('url').show().data("xurl",'live');	
			}else{
				$("#header .key-action").html("<span class='-ap icon-chevron-left2'></span>").addClass('url').show().data("xurl",'home');
			}
			
			$("#header").removeClass("-no-key-action");
		}
		
		
		$("#header .actions").html("");
		
		if (!opts.buttons || !opts.buttons.length){
			
		}else{
			for (var i=0; i<opts.buttons.length; i++){
				var action=opts.buttons[i];
				
				$("<div class='action button "+action['class']+"'>"+action.label+"</div>").appendTo("#header .actions").data("action", action.action).click(function(){
					var fn=$(this).data('action');
					fn();
				});
			}
		}
		
		if (opts.search){
			$("#header .actions").html("<div class='search'><div class='input'><input type='text' placeholder='"+opts.search.label+"'/></div></div>");
		}
		
		return this;
	};
	
	
	this.focus=function(){
		for (var i=0, j = arguments.length; i < j; i++){
			var id=arguments[i];
			if (id.charAt(0)!="#"){
				id="#"+id;
			}
			if ($(id).length){
				Menu.active(id);
				return;
			}
		}
		
	};
	
	
	
	
	
	this.initArray=function(data){
		var $canvas=$("#header .hleft .actions");
		$canvas.html("");
		$canvas.prev().hide();
		
		for (var i=0; i<data.length; i++){
			var obj=data[i];
			
			if (obj.type=="title"){
				makeTitle(obj);
			}else if (obj.type=="back"){
				var $obj;
				var url="home";
				if (obj.url && obj.url.length){
					url=obj.url;
				}else{
					if (Client.data.network){
						url=Client.data.network.path;
					}
				}
				
				var icon="chevron-left2";
				if (obj.icon){
					icon=obj.icon;
				}
				
				if (obj.label && obj.label.length){
					$obj=$("<div class='key-action'><span class='-ap icon-"+icon+"'></span> <span class='txt'>"+obj.label+"</span></div>").appendTo($canvas).addClass('url').data("url",url);	
				}else{
					$obj=$("<div class='key-action'><span class='-ap icon-"+icon+"'></span></div>").appendTo($canvas).addClass('url').data("url",url);
				}
				if (obj.dark){
					$obj.addClass("-dark");
				}
				
				if (obj.action){
					$canvas.find(".key-action").data("action", obj.action);
				}
			}else if (obj.type=="input"){
				$("<div class='search'><div class='input'><input id='"+obj.id+"' type='text' placeholder='"+obj.label+"'/></div></div>").appendTo($canvas);
			}else if (obj.type=="menu"){
				$("<div class='key-action -cmenuw'><span class='-ap icon-menu'></span> "+obj.menu+"</div>").appendTo($canvas);
			}else if (obj.type=="icon"){
				$("<div class='key-action'><span class='-ap icon-"+obj.icon+"'></span></div>").appendTo($canvas).data("url",obj.url);
			}
		}
	};
	
	
	
	this.getNetworkLinks=function(){
		if (Network.root(Client.data.network)){
			return "<div class='-cmenu xo' style='width:300px; top:47px; left:0px;'>" +
				"	<div class='-item url' data-xurl='people'>People<span class='-icon -ap icon-group text-9'></span> </div>" +
				"	<div class='-item url' data-xurl='settings'>Settings<span class='-icon -ap icon-cog3 text-9'></span></div>" +
				"	<div class='-item-sep'></div>" +
				"	<div class='-item' onclick='Company.invite();'>Invite people<span class='-icon -ap icon-person_add text-9'></span> </div>" +
				"	<div class='-item' onclick='Network.integrate();'>Integration<span class='-icon -ap icon-stack4 text-9'></span> </div>" +
			"</div>";
		}
		
		return "<div class='-cmenu xo' style='width:300px; top:47px; left:0px;'>" +
			"	<div class='-item url' data-xurl='people'>People<span class='-icon -ap icon-group text-9'></span> </div>" +
			"	<div class='-item url' data-xurl='settings'>Settings<span class='-icon -ap icon-cog3 text-9'></span></div>" +
			"	<div class='-item-sep'></div>" +
			"	<div class='-item' onclick='Network.invite();'>Invite people<span class='-icon -ap icon-person_add text-9'></span> </div>" +
			"	<div class='-item' onclick='Network.integrate();'>Integration<span class='-icon -ap icon-stack4 text-9'></span> </div>" +
		"</div>";
		
	};
	
	
	
	/**
	 * @desc Select a network
	 */
	this.selectNetwork=function(callback){
	};
	
	
	
	function makeTitle(title){
		if (AP.data.isObject(title)){
			var html= "<span class='url' data-url='"+title.url+"'>"+title.label+"</span>";
			$("#header .htitle").html(html);
		}else if (AP.data.isArray(title)){
			var html=AP.render(title, function(e, index, total){
				return "<span class='-e"+(e.active?" active":"")+" url' data-url='"+e.url+"'>"+e.label+"</span>"+(index<total-1?"<span class='-sep'></span>":"");
			});
			
			$("#header .htitle").html(html);	
		}else{
			$("#header .htitle").html(title);
		}
	}
	
};