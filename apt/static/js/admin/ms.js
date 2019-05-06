Admin.ms=new function __AdminMS(){
	this.makeAdmin=function(username){
		Context.close();
		AP.confirm("Make @<b>"+username+"</b> an admin?", function(){
			AP.ajaxShow();
			var data;
			if (Client.data.network && Client.data.network.id){
				data={username: username, role:'admin', network: Client.data.network.id};
			}else{
				data={username: username, role:'admin', system: Client.system.id};
			}
			
			AP.post("api/network/role/set", data, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				UI.flash("Privilege granted.");
				AP.trigger("user.updated", code.user);
				AP.refresh();
			});
		});
	};
	
	
	
	this.makeMember=function(username){
		Context.close();
		AP.confirm("Remove admin/owner access of @<b>"+username+"</b>?", function(){
			AP.ajaxShow();
			var data;
			if (Client.data.network && Client.data.network.id){
				data={username: username, role:'member', network: Client.data.network.id};
			}else{
				data={username: username, role:'member', system: Client.system.id};
			}
			
			AP.post("api/network/role/set", data, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				UI.flash("Privilege granted.");
				AP.trigger("user.updated", code.user);
				AP.hideAlert();
				AP.refresh();
			});
		});
	};
	
	
	
	this.revoke=function(username){
		Context.close();
		AP.confirm("Revoke access of @<b>"+username+"</b> from this team?", function(){
			var data;
			if (Client.data.network && Client.data.network.id){
				data={username: username, network: Client.data.network.id, token: Client.data.network.token};
			}else{
				return AP.alertError("Cannot revoke access from the primary team. If you want to block this user from the company, please <b>Deactivate such account</b>.")
			}
			
			AP.ajaxShow();
			AP.post("api/network/member/revoke", data, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				UI.flash("Access revoked.");
				AP.hideAlert();
				AP.refresh();
			});
		});
	};
	
	
	
	
	this.makeOwner=function(username){
		Context.close();
		AP.confirm("Make @<b>"+username+"</b> an owner?", function(){
			AP.ajaxShow();
			var data={};
			
			if (Client.data.network){
				data={username: username, role:'owner', network: Client.data.network.hid, token: Client.data.network.token};	
			}else{
				data={username: username, role:'owner', network: Client.root_nework_id};
			}
			
			
			AP.post("api/network/role/set",data, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				UI.flash("Privilege granted.");
				AP.trigger("user.updated", code.user);
				AP.hideAlert();
			});
		});
	};
	
	
};