Admin.sa=new function __AdminSpecialAccess(){

	this.edit=function(username){
		var user=People.get(username);
		if (!user){
			return;
		}
		
		var accesses=[{name: "hr.admin", color: 4}, {name: "training.admin", color: 3}, {name: "checkin.admin", color: 5}, {name: "asset.admin", color: 2}];
		var form=Form.create('create-team-fx',{action: 'api/sa/edit'})
		.row(
			Form.label({label: "Tài khoản",sublabel: ""}),
			Form.input({name: 'name_fake', type: "fake", value: username}).value(user.name)
		)
		.row(
			Form.label({label: "Special accesses *",sublabel: "Pick all access"}),
			Form.input({name: 'accesses', placeholder: "Type to pick accesses"})
		)
		.hiddens({
			token:Client.system.token,
			username: username
		})
		.render(function($f){
			var $input=$f.find("accesses");
			AP.UI.tagcloud($input, accesses, user.sas);
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
	
		Form.pop({id: 'create-team-fx-dx', width: 500, label: 'Grant special access'}).setForm(form).show();
		
	};
	
	
	
	this.setIPRange=function(){
		var form=Form.create('create-team-fx',{action: 'api/company/ipconfig/set'})
		.row(
			Form.label({label: "Set ip ranges (commas for multiple ranges)"}),
			Form.input({name: 'ips', type: "text", placeholder: "Leave blank for all ip accesses"}).value(Client.base.ipranges)
		)
		.hiddens({
			token:Client.system.token,
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Save setting", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Update successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Set IP range', layout: "block"}).setForm(form).show();
		
	};

	
	
	
	this.setUserIPRange=function(username, ranges){
		var user=PeopleMng.info(username, function(user){
			if (!user){
				return true;
			}
			
			var form=Form.create('create-team-fx',{action: 'api/company/ipconfig/user.set'})
			.row(
				Form.label({label: "Set ip ranges (commas for multiple ranges)"}),
				Form.input({name: 'ips', type: "text", placeholder: "Leave blank for all ip accesses"}).value(user.ips)
			)
			.hiddens({
				token:Client.system.token,
				username: user.username
			})
			.render(function($f){
			})
			.buttons([
				 {label: "Save setting", action: function(){
					 Form.submit("#create-team-fx", function(code){
						 if (!code.good()){
							 return AP.alertError(code.message);
						 }
					
						 Form.hide("create-team-fx");
						 AP.alertSuccess("Update successfully", function(){
							 AP.refresh();
						 });
					 });
				 }, style: 'ok -success -rounded -bold'},
				 {label: "Cancel", action: function(){
					 Form.hide("create-team-fx");
				 }, style:'cancel -passive-2 -rounded'}
			]).settings();
		
			Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Set IP range for '+user.name, layout: "block"}).setForm(form).show();
		});
	};
	
	
	
	
	this.setGroupIPRange=function(group_id, group_name){
		var form=Form.create('create-team-fx',{action: 'api/company/ipconfig/group.set'})
		.row(
			Form.label({label: "Set ip ranges (commas for multiple ranges)"}),
			Form.input({name: 'ips', type: "text", placeholder: "Leave blank to remove IP block"})
		)
		.hiddens({
			token:Client.system.token,
			id: group_id
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Save setting", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Update successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Set Group IP range for group: '+group_name, layout: "block"}).setForm(form).show();
	};
	
	
	this.setPrivacy=function(){
		var form=Form.create('create-team-fx',{action: 'api/company/privacy/set'})
		.row(
			Form.label({label: "Quyền xem thông tin"}),
			Form.input({name: 'privacy', type: "select", options: [{label:"Public (Công khai thông tin liên hệ của tất cả nhân viên)", value:0}, {label:"Private (Chỉ hiển thị thông tin cho người quản lý và admin)", value:1}]}).value(Client.system.privacy)
		)
		.hiddens({
			token:Client.system.token,
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Save setting", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Update successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Quyền xem thông tin', layout: "block"}).setForm(form).show();
		
	};
	
	
	this.setAppUser=function(){
		var actions=[];
		for (var i=0; i<Client.subs.length; i++){
			var limit=Client.subs[i].limit;
			if (!limit){
				limit=Client.system.user_limit;
				Client.subs[i].limit=limit;
			}
			actions.push({label: Client.subs[i].app+" &rsaquo; " +Client.subs[i].sub, sublabel: "No more than <b>"+limit+"</b> users",data: Client.subs[i]});
		}
		
		AP.selectAction(actions, function(e){
			setUsersForApp(e.data);
		}, {title:"Please pick a subscription"});
	};
	
	
	this.disable2FA=function(username){
		AP.confirm("Disable two factor authentication?", function(){
			UI.ajaxShow();
			AP.post("api/company/2fa/disable", {username: username}, function(code){
				UI.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("Disable successfully ...");
			});
		});
	};
	
	
	
	
	this.setUserPassword=function(username){
		var user=People.get(username);
		if (!user){
			return;
		}
		
		var form=Form.create('create-team-fx',{action: 'api/company/user/setpassword'})
		.row(
			Form.label({label: "User"}),
			Form.input({name: 'text', type: "fake", placeholder: "User password"}).value("<b>"+user.name+"</b> ("+user.username+")")
		)
		.row(
			Form.label({label: "Password"}),
			Form.input({name: 'password', type: "password", placeholder: "User password"})
		)
		.row(
			Form.label({label: "Retype password"}),
			Form.input({name: 'repassword', type: "password", placeholder: "Retype password"})
		)
		.hiddens({
			username: username,
			token:Client.system.token,
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Set password", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Update successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Set user password', layout: "block"}).setForm(form).show();
		
	};
	
	
	this.setUserEmail=function(username){
		var user=People.get(username);
		if (!user){
			return;
		}
		
		var form=Form.create('create-team-fx',{action: 'api/company/user/setemail'})
		.row(
			Form.label({label: "User"}),
			Form.input({name: 'text', type: "fake", placeholder: "User"}).value("<b>"+user.name+"</b> ("+user.email+")")
		)
		.row(
			Form.label({label: "Email"}),
			Form.input({name: 'email', type: "text", placeholder: "User email"})
		)
		.hiddens({
			username: username,
			token:Client.system.token,
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Set email", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Update successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Set user email', layout: "block"}).setForm(form).show();
		
	};
	
	
	
	function setUsersForApp(app){
		$.log(app);
		
		var users=[];
		if (app.users){
			users=app.users;
		}
		
		var form=Form.create('create-team-fx',{action: 'api/sub/users'})
		.row(
			Form.label({label: "Targeted app"}),
			Form.input({name: 'text', type: "fake", placeholder: "App"}).value(app.app)
		)
		.row(
			Form.label({label: "Select users (limit "+app.limit+")"}),
			Form.input({name: 'usernames', type: "text", placeholder: "Type @ to tag", role:"tag"}).value(users)
		)
		.row(
			Form.label({label: "Or quick select users by teams"}),
			Form.input({name: 'teams', type: "text", placeholder: "Type @ to tag", role:"teams"})
		)
		.hiddens({
			app: app.app
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Set users", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("Update successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Set user for app '+app.app, layout: "block"}).setForm(form).show();
		
	}
	
};