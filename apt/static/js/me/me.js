var Me=new function __Me(){
	this.isSystemOwner=function(){
		var obj=Network.get(Client.system.root_network_id);
		return (obj && parseInt(obj.role)==Role.OWNER);
	};
	
	this.isSystemAdmin=function(){
		var obj=Network.get(Client.system.root_network_id);
		return (obj && (parseInt(obj.role)==Role.ADMIN || parseInt(obj.role)==Role.OWNER));
	};
	
	
	this.isMemberOf=function(network){
		var obj=null;
		
		if (AP.data.isString(network)){
			obj=Network.getByPath(network);
		}else{
			obj=Network.get(network.id);	
		}
		return (obj!=null);
	};
	
	this.isNetworkOwner=function(network){
		var obj=null;
		
		if (AP.data.isString(network)){
			obj=Network.getByPath(network);
		}else{
			obj=Network.get(network.id);	
		}
		return (obj && parseInt(obj.role)==Role.OWNER);
	};
	
	this.isNetworkAdmin=function(network){
		if (!network){
			if (Client.pageData.network){
				network=Client.pageData.network;
			}else{
				network=Company.getRootNetwork();	
			}
		}
		
		if (!network){
			return false;
		}
		var obj=Network.get(network.id);
		
		return (obj && (parseInt(obj.role)==Role.ADMIN || parseInt(obj.role)==Role.OWNER));
	};
	
	
	this.isFollower=function(obj){
		if (!obj){
			return false;
		}
		
		for (var i=0; i<obj.followers.length; i++){
			if (AP.data.isString(obj.followers[i])){
				if (obj.followers[i]==Client.viewer.username){
					return true;
				}
			}else{
				if (obj.followers[i].username==Client.viewer.username){
					return true;
				}	
			}
		}
		
		return false;
	};
	
	
	this.isOwner=function(obj){
		if (!obj){
			return false;
		}
		
		for (var i=0; i<obj.owners.length; i++){
			if (obj.owners[i].username==Client.viewer.username){
				return true;
			}
		}
		
		return false;
	};
	
	
	this.isAssigned=function(obj){
		return (parseInt(Client.viewer.id)==parseInt(obj.assign_to));
	}
	
	
	this.isCreator=function(obj){
		if (!obj || !obj.user_id){
			return;
		}
		return (parseInt(Client.viewer.id)==parseInt(obj.user_id));
	}
	
	this.findObject=function(objs){
		for (var i=0; i<objs.length; i++){
			if (AP.data.isString(objs[i])){
				if (objs[i]==Client.viewer.username){
					return objs[i];
				}
			}else{
				if (objs[i].username==Client.viewer.username){
					return objs[i];
				}	
			}
		}
		
		return null;
	};
	
	
	this.join=function(hid, token){
		AP.confirm("Are you sure that you want to join this team?", function(){
			AP.post("api/network/member/join",{hid: hid, token: token}, function(code){
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("You've joined the team successfully!", function(){
					AP.refresh();
				});
			});
		});
	};
	
	
	this.favor=function(obj){
		return AP.array.contain(Client.favors, obj, function(elem, xobj){
			if (AP.data.isInt(elem)){
				return elem && elem==xobj.id;
			}
			return (elem && elem.hid && elem.hid==xobj.hid);
		});
	};
	
	
	this.setFavorite=function(id, callback){
		var data={};
		var identify=id;
		if (AP.data.isObject(id)){
			identify=id.hid;
			data={hid: id.hid, token: id.token, object: 1};
		}else{
			data={id: id};
		}
		
		UI.ajaxShow();
		AP.post("api/me/favorite", data, function(code){
			UI.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			Client.favors=code.favors;
			if (AP.data.isObject(id)){
				Menu.buildFavorLists();
			}
			
			AP.fire("favor-"+identify);
			
			if (callback){
				callback(code.favors);	
			}
		});
	};
	

	
	this.getFavorites=function(){
		var r=[];
		for (var i=Client.favors.length-1; i>=0; i--){
			var id=Client.favors[i];
			if (AP.data.isObject(id)){
				r.push(id);
			}else{
				var team=Network.get(id);
				if (team){
					r.push(team);
				}	
			}
		};
		return r;
	};
	
	
	
	this.arrangeFavorites=function(id, callback){
		var teams=this.getFavorites();
				
		var options=[];
		for (var i=0; i<teams.length; i++){
			if (teams[i].ref && teams[i].ref==1){
				options.push({id: teams[i].hid, "label": teams[i].name, sublabel: teams[i].type+"", data: teams[i]});
			}else{
				options.push({id: teams[i].id, "label": teams[i].name, "sublabel": "/"+teams[i].path+"", data: teams[i]});
			}
		}
		
		
		UI.reorder(options, "api/me/favorite.reorder").callback(function(id, ord, code){
			Client.favors=code.favors;	
			Menu.buildFavorLists();
		},{"title":"Reorder favorites"});
	
	};
	
	
	this.removeFavorite=function(id, callback){
		var identify=id;
		if (AP.data.isObject(id)){
			identify=id.hid;
			data={hid: id.hid, token: id.token, object: 1};
		}else{
			data={id: id};
		}
		
		AP.post("api/me/favorite", {id: id, 'remove': 1}, function(code){
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			callback(code.favors);
			AP.fire("unfavor-"+identify);
		});
	};
	
	
	this.logout=function(){
		AP.confirm("Are you sure that you want to logout now?", function(){
			return AP.redirect("a/logout?token="+Client.viewer.token);
		});
	};
	
	this.chooseColor=function(){
		var form=Form.create('color-fx',{'action':'api/me/color'})
		.row(
			Form.label({label: "Choose a color to inspire your working day<br><br>"}),
			Form.input({name: 'color', type:"colors"}).value(Client.viewer.color)
		)
		.buttons([
			 {label: "Save color", action: function(){
				 Form.submit("color-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
					 
					 if (Client.native){
						 Cache.set("color", code.color);
					 }
					 
					 Form.hide("color-fx");
					 UI.flash("Color set ...");
					 AP.refresh();
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("color-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings({block: true});
	
		Form.pop({id:'color-fx-dx', width: 600, label: 'Choose favorite color'}).setForm(form).show();
	};
	
	
	this.delegate=function(){
		var user=Client.viewer;
		var delegate=user.delegate;
		if (!delegate || !delegate.username){
			delegate={username:""};
		}
		
		var form=Form.create('edit-profile-fx',{'action':'api/me/delegate'})
		.row(
			Form.label({label: "Delegate to",sublabel: ""}),
			Form.input({name: 'username', "placeholder":"Type to tag", role:"tag"}).value("@"+delegate.username)
		)
		.row(
			Form.label({label: "From date",sublabel: ""}),
			Form.input({name: 'sdate', role:"date", placeholder:"From date"}).value(delegate.sdate)
		)
		.row(
			Form.label({label: "To date",sublabel: ""}),
			Form.input({name: 'edate', role:"date", placeholder:"To date"}).value(delegate.edate)
		)
		.buttons([
			 {label: "Save setting", action: function(){
				 Form.submit("edit-profile-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("edit-profile-fx");
					 AP.alertSuccess(code.message, function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("edit-profile-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id:'edit-fx-dx', width: 450, label: 'Delegation on leave'}).setForm(form).show();
		
	};
	
	
	this.arrangeTeams=function(){
		var options=[];
		for (var i=0; i<Client.networks.length; i++){
			var net=Client.networks[i];
			if (!AP.array.contain(Client.favors, net.id)){
				options.push({id: net.id, "label": net.name, "sublabel": "/"+net.path+""});	
			}
		}
		
		UI.reorder(options, "api/me/network/reorder").callback(function(id, ord){
			var $elem=$("#team-"+id);
			
			if (ord==-1){
				var $base=$elem.prev('.-team');
				
				if ($base && $base.length){
					$elem.insertBefore($base);
				}
			}else{
				var $base=$elem.next('.-team');
				if ($base && $base.length){
					$elem.insertAfter($base);
				}
			}
		});
	};
	
	
	this.mailTo=function(username){
		AP.alertError("This feature was temporarily disabled.");
	};
	
	
	this.chatWith=function(username){
		Chat.peer(username, "", true);
		Context.hide();
	}
};


"<@require twofactor.js>";