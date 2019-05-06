var GuestMng=new function __PeopleMng(){
	
	this.reactivate=function(username){
		Context.close();
		AP.confirm("Please confirm that you will reactivate the guest account @<b>"+username+"</b>? This action cannot be undone.", function(){
			AP.ajaxShow();
			AP.post("api/guest/reactivate",{username: username}, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("Guest account reactivated.", function(){
					AP.refresh();
				});
			});
		});
	};
	
	
	this.display=function(users){
		if (!users){
			users=Client.people;
		}
		
		var html=AP.render(users, getPersonHTML);
		$("#people-list").html(html);
		
		fixCounters(users);
		
		var tab=tab=Query.get("tab");
		if (tab && tab.length){
			PeopleMng.show(tab, true);
		}
		
		
		Online.loaded(function(){
			Online.reorder(users);
			var html=AP.render(users, getPersonHTML);
			$("#people-list").html(html);
			
			fixCounters(users);
			
			var tab=tab=Query.get("tab");
			if (tab && tab.length){
				PeopleMng.show(tab, true);
			}
		});
		
	};
	
	
	this.show=function(tab, inline){
		
		if (!tab){
			tab=Query.get("tab");
		}
		
		$("#mngheader .menu .tab").setActive(".tab-"+tab);
		
		if (Client.path.current=="company/chart" && !inline){
			if (tab=="chart"){
				return AP.toURL("company/chart");
			}else{
				return AP.toURL("company?tab="+tab);
			}
		}
		
		
		if (tab=="online"){
			clearSearch();
			$("#people-list > .li").hide();
			$("#people-list > .li.-online").show();
		}else if (tab=="admins"){
			clearSearch();
			$("#people-list > .li").hide();
			$("#people-list > .li.-admin").show();
			$("#people-list > .li.-owner").show();
		}else if (tab=="chart" && !inline){
			AP.toURL("company/chart");
		}else{
			clearSearch();
			$("#people-list > .li").show();
		}
	};
	
	
	this.filter=function(query){
		if (!query || !query.length){
			$("#people-list > .li").show();
			return;
		}
		
		query=query.toLowerCase();
		
		$("#people-list > .li").each(function(){
			var name=$(this).find(".text b.username").text().toLowerCase();
			var username=$(this).find(".text .sub b").text().toLowerCase();
			
			if (name.indexOf(query)>=0 || username.indexOf(query)>=0){
				$(this).show();
			}else{
				$(this).hide();
			}
		});
	};
	
	
	
	this.selectOptions=function(ref, username){
		var edit_by_admin=[];
		
		if (Me.isSystemAdmin() && Client.viewer.username!=username){
			edit_by_admin.push({'type' :'sep'});
			edit_by_admin.push({label: "Chỉnh sửa tài khoản", "icon":"icon-uniF116", action: function(){Admin.edit(username);}});
		}
		
		if (Me.isSystemOwner()){
			edit_by_admin.push({label: "Phân quyền sử dụng apps", icon:"icon-uniF107", action: function(){GuestMng.editAccess(username);}});
			edit_by_admin.push({label: "Thay đổi mật khẩu", icon:"icon-uniF14B", action: function(){GuestMng.editPassword(username);}});
			
			var user=AP.array.single(Client.pageData.guests, function(e){
				return e.username==username;
			});
			
			if (user && parseInt(user.status)==-1){
				edit_by_admin.push({label: "Reactivate tài khoản này", "icon":"icon-ion-ios-checkmark", action: function(){GuestMng.reactivate(username);}});	
			}else{
				edit_by_admin.push({label: "Deactivate tài khoản này", icon:"icon-stop3", action: function(){Admin.deactivate(username);}});	
			}
			
			// edit_by_admin.push({label: "Deactivate tài khoản này", icon:"icon-uniF11F", action: function(){Admin.deactivate(username);}});
		}
		
		return Context.menu(ref, {top: 30, left:-240, menu: [
			{label: 'Xem profile chi tiết', 'icon': 'icon-uniF15F icm', action: 'user/'+username},
			{label: 'Chat với @<b>'+username+'</b>', 'icon': 'icon-uniF1D7', action: function(){
				Base.message.peer(username, {'from': 'context'});
				Context.hide();
			}}
		].concat(edit_by_admin)});
	};
	
	
	this.editPassword = function(username){
		var form=Form.create('edit-profile-fx',{'action':'api/guest/edit.password'})
		.row(
			Form.label({label: "New password",sublabel: "Your new password"}),
			Form.input({name: 'new_password', "type":"password", "placeholder":"New password"})
		)
		.row(
			Form.label({label: "Retype new password", sublabel: "Repeat your new password"}),
			Form.input({name: 'new_password2', type: "password", "placeholder":"Retype your new password"})
		)
		.hiddens({
			username: username
		})
		.buttons([
			 {label: "Change password", action: function($this){
				 Form.submit("edit-profile-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
					 
					 Form.hide("edit-profile-fx");
					 AP.alertSuccess("Password was updated successfully");
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("edit-profile-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id:'edit-fx-dx', width: 600, label: 'Change guest password'}).setForm(form).show();
		
	};
	
	
	
	
	
	this.editAccess=function(username){
		var user=People.get(username);
		if (!user){
			return;
		}
		
		var v="";
		if (user.accesses && user.accesses.length){
			v=user.accesses.join(", ")
		}
		
		var accesses=[{name: "wework", color: 4}, {name: "talent", color: 3}, {name: "okr", color: 5}, {name: "request", color: 5}, {name: "inside", color: 5}];
		var form=Form.create('create-team-fx',{action: 'api/guest/access'})
		.row(
			Form.label({label: "Tài khoản",sublabel: ""}),
			Form.input({name: 'name_fake', type: "fake", value: username}).value(user.name)
		)
		.row(
			Form.label({label: "App accesses *",sublabel: "Pick all apps"}),
			Form.input({name: 'accesses', placeholder: "Type to pick accesses"})
		)
		.hiddens({
			token:Client.system.token,
			username: username
		})
		.render(function($f){
			var $input=$f.find("accesses");
			AP.UI.tagcloud($input, accesses, user.accesses);
		})
		.buttons([
			 {label: "Save accesses", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Special accesses updated for @"+username, function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 500, label: 'Grant app access'}).setForm(form).show();
	
		
	};
	
	
	
	
	function fixCounters(users){
		var online=0;
		var admins=0;
		var owners=0;
		
		for (var i=0; i<users.length; i++){
			if (users[i].online){
				online++;
			}
			
			if (parseInt(users[i].role)==13){
				owners++;
			}else if (parseInt(users[i].role)==10){
				admins++;
			}
		}
		
		$("#mngheader .tab.tab-everyone .counter").html("("+users.length+")");
		$("#mngheader .tab.tab-online .counter").html("("+online+")");
		$("#mngheader .tab.tab-admins .counter").html("("+(admins+owners)+")");
	};
	
	
	function clearSearch(){
		$("#people-search-ip").val("");
	};
	
	function updateStatus(){
		$("#people-canvas .list").children().each(function(){
			var username=$(this).data("username");
			if (Online.online(username)){
				$(this).find(".avatar").addClass("-online");
				$(this).prependTo("#people-canvas .list");
			}
		});
	};
	
	
	function getPersonHTML(e){
		var priv="Member since "+UI.simpleTime(e.since);
		var status="";
		var eclass="";
		
		if (Online.online(e.username)){
			status=" -online";
			eclass=" -online";
		}
		
		var priv="";
		if (parseInt(e.role)==13){
			priv="<b class='red'>Owner</b> &nbsp;&middot;&nbsp; ";
			eclass+=" -owner";
		}else if (parseInt(e.role)==10){
			priv="<b class='red'>Admin</b> &nbsp;&middot;&nbsp; ";
			eclass+=" -admin";
		}
		
		return "<div class='li -icon-left unselectable"+eclass+"' data-username='"+e.username+"'>" +
			"	<div class='icon'><div class='avatar avatar-60 -rounded "+status+"'><span class='image'><img src='"+AP.xthumb(e.gavatar)+"'/></span></div></div>" +
			"	<div class='text ap-xdot'>" +
			"		<b class='url std' data-url='user/"+e.username+"'>"+e.name+"</b>" +
			"		<div class='sub ap-xdot'>@<b class=''>"+e.username+"</b> &nbsp;&middot;&nbsp; "+___(e.title,"<i class='opt-80'>No title</i>")+"</div>" +
			"		<div class='sub ap-xdot'>"+priv+"Member since "+UI.simpleTime(e.since)+"</div>"+
			"	</div>" +
			"	<div class='minfo list-info'>" +
			"		<div class='li ap-xdot'><span class='-ap icon-email'></span> &nbsp; "+e.email+"</div>" +
			"		<div class='li ap-xdot'><span class='-ap icon-phone4'></span> &nbsp; "+___(e.phone,"<i class='opt-80'>Phone number not set</i>")+"</div>" +
			"		<div class='li ap-xdot'><span class='-ap icon-location5'></span> &nbsp; "+___(e.address,"<i class='opt-80'>Address not set</i>")+"</div>" +
			"	</div>"+
			"	<div class='action -more pointer' onclick=\"GuestMng.selectOptions(this, '"+e.username+"');\"></div>" +
			"</div>";
	};
};