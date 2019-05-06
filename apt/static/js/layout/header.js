var Header = new function __Header(){
	this.networks={};
	this.users={};
	this.apps=[];
	
	this.init=function(){
		buildSystems();
		$("#header .logo .name").html(Client.system.name);
	};
	
	
	this.initApps=function(){
		$("#header .links").show();
		var apps=[];
		
		$("#header .links > .item").each(function(){
			var app=$(this).data('app');
			if (app=="home"){
				return;
			}
			
			if ($(this).hasClass("last")){
				return;
			}
		
			apps.push({html: $(this).clone(true), width: $(this).width()+10, key: app, id: AP.uuid()});
			$(this).remove();
		});
		
		this.apps=apps;
		this.buildApps();
		this.orderApps();
		
	};
	
	
	this.buildApps=function(){
		var apps=Header.apps;
		var $ms=$("#header .links > .item.last");
		$ms.find(".menu .li.url").remove();
		
		$("#header .links > .item").each(function(){
			if ($(this).data('app')=="home"){
				return;
			}
			
			if ($(this).hasClass("last")){
				return;
			}
			
			$(this).remove();
		});
		
		
		for (var i=0; i<Client.system.applist.length; i++){
			var app=AP.array.find(apps, function(e){
				return (e.key==Client.system.applist[i]);
			});
			
			if (app){
				app.html.insertBefore($ms).addClass("app").attr("id", app.id);
			}
		}
	};
	
	
	
	this.orderApps=function(){
		AP.html.resize(function(){
			var cw=0;
			var tw=$(window).width()-220 - 260 -130;
			var $extra=$("#header .links > .item.last .menu .last")
			
			for (var i=0; i<Client.system.applist.length; i++){
				var app=AP.array.find(Header.apps, function(e){
					return (e.key==Client.system.applist[i]);
				});
				
				if (!app){
					continue;
				}
				
				cw=cw+app.width;
				
				if (cw > tw || i>=5){
					$("#"+app.id).hide();
					
					var more=AP.array.find(Conf.apps, function(e){
						return e.key==Client.system.applist[i];
					});
					
					
					if (more && (!more.disable || Client.viewer.id==1)){
						$extra.parent().find(".app-extra-"+more.key).remove();
						$("<div class='li url app-extra-"+more.key+"' data-url='"+more.url+"'>"+more.name+"</div>").insertBefore($extra);	
					}
				}else{
					$("#"+app.id).show();
					$extra.parent().find(".app-extra-"+app.key).remove();
				}
				
				
			}
		}, true)
	};
	
	
	
	function buildSystems(){
		var systems="";
		
		if (!Client.systems || !Client.systems.length || Client.systems.length<=1){
			if (Client.system.id==1){ 
				systems="<div class='-item-sep'></div> <div class='-item' onclick='Company.createSystem();'>Create a new system<span class='-icon -ap icon-add2 text-9'></span></div>";
			}
			
			$("#account-main-menu .-item-last").before(systems);
			
			return;
		}
		
		
		systems=AP.render(Client.systems, function(e){
			if (e.id==Client.system.id){
				return "<div class='-item bold'>"+e.name+"<span class='-icon -ap -big icon-screen2'></span></div>";
			}else{
				var link=e.url+"?switch="+e.token;
				return "<a class='-item none normal none' target='_blank' href='"+link+"'>"+e.name+"<span class='-icon -ap icon-screen2 text-9'></span></a>";	
			}
		});
		
		/**
		 * @todo This is a hack
		 */
		if (Client.system.id==1){ 
			systems+="<div class='-item-sep'></div> <div class='-item' onclick='Company.createSystem();'>Create a new system<span class='-icon -ap icon-add2 text-9'></span></div>";
		}
		
		$("#account-main-menu .-item-last").before("<div class='-item-sep'></div>"+systems);
		
		return;
	};
};