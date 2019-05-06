var Network=new  function __Network(){
	this.favorMe=function(){
		if (!Client.data.network){
			return;
		}
		
		if (Me.favor(Client.data.network)){
			var id=Client.data.network.id;
			Me.removeFavorite(id, function(fs){
				Client.favors=fs;
				UI.flash("Team removed to from favourite!");
				
				$("#team-"+id).removeClass("-favour").slideUp(150, function(){
					$(this).prependTo("#teams").slideDown(400);
				});
			});
		}else{
			var id=Client.data.network.id;
			Me.setFavorite(id, function(fs){
				UI.ajaxHide();
				Client.favors=code.favors;
				UI.flash("Team set to favourite!");
				$("#team-"+id).addClass("-favour").slideUp(150, function(){
					$(this).insertAfter("#menu .section.-favorite .last").slideDown(400);
				});
			});
		}
	};
	
	this.leave=function(){
		if (!Client.data.network){
			return;
		}
		
		if (this.root()){
			return AP.alertError("You can not leave the company.");
		}
		
		AP.confirm("Are you sure that you want to leave the team <b>"+Client.data.network.name+"</b> now? This action cannot be undone.", function(){
			AP.ajaxShow();
			AP.post("api/network/member/leave",{hid: Client.data.network.hid, token: Client.data.network.token}, function(code){
				AP.ajaxHide();
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("You've just left the team!", function(){
					AP.redirect("home");
				});
			});
		});
		
	};
	
	this.root=function(network){
		if (network){
			return AP.data.equal(network.type, this.type.types.root)
		}
		return Client.data.network && AP.data.equal(Client.data.network.type, this.type.types.root);
	};
	
	
	this.select=function(title, callback){
		if (!callback){
			callback=null;
		}
		
		var actions=[];
		for (var i=0; i<Client.networks.length; i++){
			var e=Client.networks[i];
			actions.push({id:e.id, hid: e.hid, token: e.token, label: e.name, name:e.name, sublabel: Client.system.domain+"/"+e.path+" &middot; "+e.num_people+" people", value: 1});
		}
		
		AP.selectAction(actions, function(action){
			if (callback){
				callback(action);
			}
		},{title: title});
	};
	
	
	this.invite=function(){
		if (this.root() || !Client.data.network){
			return Company.member.inviteDialog();
		}else{
			return this.member.inviteDialog();
		}
	};
	
	
	this.inviteList=function(content, callback, error){
		AP.post("api/network/member/invite",{list: 1, network: Client.data.network.id, token: Client.data.network.token, usernames: content}, function(code){
			if (!code.good()){
				if (error){
					error(code.message);
				}
				return AP.alertError(code.message);
			}
			
			callback(code.usernames);
		});
	};
	
	
	
	this.get=function(id){
		if (AP.data.isInt(id)){
			return AP.array.findObj(Client.networks, id);	
		}
		
		for (var i=0; i<Client.networks.length; i++){
			if (Client.networks[i].path==id){
				return Client.networks[i];
			}
		}
		
		return null;
	};
	
	this.getByPath=function(path){
		for (var i=0; i<Client.networks.length; i++){
			if (Client.networks[i].path==path){
				return Client.networks[i];
			}
		}
		
		return null;
	};
	
	
	this.settings=function(){
		var admin=false;
		if (Client.data.network && Me.isNetworkAdmin(Client.data.network)){
			admin=true;
		}
		
		if (Me.isSystemOwner()){
			admin=true;
		}
		
		if (admin){
			var options=[];
			options.push({"label":"Edit this user group", "icon":"cog", action: function(){
				Network.editSelf();
			}});
			
			if (Me.isSystemOwner()){
				options.push({"label":"Mass setup IP range", "icon":"shield", action: function(){
					Admin.sa.setGroupIPRange(Client.data.network.id, Client.data.network.name);
				}});
			}
			
			options.push({"label":"Invite more people", "icon":"person_add", action: function(){
				Network.invite();
			}});
			
//			options.push({"label":"Team preferences &amp; settings", "icon":"lock_outline", action: function(){
//				Network.preference();
//			}});
			
//			options.push({"label":"My personal preferences", "icon":"favorite_outline", action: function(){
//				Network.personalPreference();
//			}});
			
			if (!Network.root()){
				if (Client.data.network && Client.pageData.settings_team && Client.pageData.settings_team.leave=="yes"){
					options.push({"label":"Leave the team now", "icon":"power_settings_new", action: function(){
						Network.leave();
					}});
				}

				if (Me.isSystemOwner()) {
					options.push({"label":"<span class='red'>Delete this team (System Owner only)</span>", "icon":"cloud_off", action: function() {
						Network.ownerRemove();
					}});
				}
			}
			
			AP.actionMenu(options);
			return;
		}else{
			var options=[];
			options.push({"label":"My personal preferences", "icon":"favorite_outline", action: function(){
				Network.personalPreference();
			}});
			
			if (Client.data.network && Client.pageData.settings_team && Client.pageData.settings_team.leave=="yes"){
				options.push({"label":"Leave the team now", "icon":"power_settings_new", action: function(){
					Network.leave();
				}});
			}
			
			AP.actionMenu(options);
			return;
		};	
	};
	
	
	
	this.preference=function(){
		UI.setting("Team preferences &amp; settings")
		.add({
			title: "Who can create regular posts?", 
			options: {"everyone":"Everyone","admin":"Team admins and owners", "owner":"Only team owners"}, 
			value: Client.pageData.settings_team.update,
			name:"update",
			url: "api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Who can create new topics?", 
			options: {"everyone":"Everyone","admin":"Team admins and owners", "owner":"Only team owners"}, 
			value: Client.pageData.settings_team.topic,
			name:"topic",
			url:"api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Who can post announcements?", 
			options: {"everyone":"Everyone","admin":"Team admins and owners", "owner":"Only team owners"}, 
			value: Client.pageData.settings_team.announcement,
			name:"announcement",
			url:"api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Grant posting announcements permission to some extra users? <small><i>Note.</i> This is an exception.</small>", 
			options: ":custom:users", 
			value: Client.pageData.settings_team.announcement_extra,
			name:"announcement_extra",
			url:"api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Who can use tag <b>@all</b> to tag everyone?", 
			options: {"everyone":"Everyone","admin":"Team admins and owners", "owner":"Only team owners"}, 
			value: Client.pageData.settings_team.tagall,
			name:"tagall",
			url:"api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Share posts of this team to its members' home feeds? <small><i>Note.</i> Each member can also have his/her own preference.</small>", 
			options: {"yes":"Yes","no":"No"}, 
			value: Client.pageData.settings_team.share,
			name:"share",
			url:"api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Allow team members to delete their own posts?", 
			options: {"yes":"Yes","no":"No"},
			value: Client.pageData.settings_team.delete_post,
			name:"delete_post",
			url:"api/network/setting/"+Client.data.network.hid
		})
		.add({
			title: "Allow team members to leave? <small><i>Note.</i> If allowed, team members can leave the team by themselves. In any cases, team owners can remove members.</small>", 
			options: {"yes":"Yes","no":"No"}, 
			value: Client.pageData.settings_team.leave,
			name:"leave",
			url:"api/network/setting/"+Client.data.network.hid,
		})
		.show();
	};
	
	
	
	
	this.personalPreference=function(){
		UI.setting("Personal preferences")
		.add({
			title: "Share posts from this team to my home's newsfeeds? <small>Note: Automatic means that this setting is based on the team's current setting.</small>", 
			options: {"auto":"Automatic","yes":"Yes","no":"No"}, 
			value: Client.pageData.settings_team.update,
			name:"update",
			url: "api/network/preference/"+Client.data.network.hid
		})
		.show();
	};
	
	
	
	
	this.editSelf=function(){
		Company.editNetwork(Client.data.network);
	};


	this.ownerRemove = function () {
		if (!Client.data.network) {
			return;
		}

		if (!Me.isSystemOwner()) {
			return AP.alertError("You do not have enough permission.");
		}

		if (this.root()) {
			return AP.alertError("You can not remove root network.");
		}

		AP.confirm("Are you sure that you want to delete the team <b>" + Client.data.network.name + "</b> now? This action cannot be undone.", function () {
			AP.ajaxShow();
			AP.post("api/network/owner.remove", {
				hid: Client.data.network.hid,
				token: Client.data.network.token
			}, function (code) {
				AP.ajaxHide();
				if (!code.good()) {
					return AP.alertError(code.message);
				}

				AP.alertSuccess("The team was deleted!", function () {
					AP.redirect("home");
				});
			});
		});

	};
};