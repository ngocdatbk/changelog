var Admin=new function __AdminTool(){
	this.deactivate=function(username){
		Context.close();
		AP.confirm("Deactivate @<b>"+username+"</b>'s account? This will be blocked @<b>"+username+"</b>'s access forever. This action cannot be undone.", function(){
			AP.ajaxShow();
			AP.post("api/company/deactivate",{username: username}, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("Account deactivated.", function(){
					AP.refresh();
				});
			});
		});
	};
	
	
	
	
	this.reactivate=function(username){
		Context.close();
		AP.confirm("Please confirm that you will reactivate @<b>"+username+"</b>'s account? This action cannot be undone.", function(){
			AP.ajaxShow();
			AP.post("api/company/reactivate",{username: username}, function(code){
				AP.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("Account reactivated.", function(){
					AP.refresh();
				});
			});
		});
	};
	
	
	
	
	this.edit=function(username){
		UI.ajaxShow();
		AP.post("api/company/user.info", {username: username}, function(code){
			UI.ajaxHide();
			
			if (!code.good()){
				return;
			}
			
			var user=code.user;
			var dates=range(1,31);
			dates.unshift({label: "-- Chọn ngày --", value: 0});
			
			var months=range(1,12);
			months.unshift({label: "-- Chọn tháng --", value: 0});
			
			var years=range(2010,1930);
			years.unshift({label: "-- Chọn năm --", value: 0});
			
			
			
			var form=Form.create('edit-profile-fx',{'action':'api/company/user.edit'})
			.row(
				Form.label({label: "First name",sublabel: "The first name"}),
				Form.input({name: 'first_name', "placeholder":"First name"}).value(user.first_name)
			)
			.row(
				Form.label({label: "Last name",sublabel: "The last name"}),
				Form.input({name: 'last_name', "placeholder":"Last name"}).value(user.last_name)
			)
			.row(
				Form.label({label: "Email", sublabel: "Email address"}),
				Form.input({name: 'email', type: "fake", "placeholder":"Email address"}).value(user.email)
			)
			.row(
				Form.label({label: "Username", sublabel: "The username"}),
				Form.input({name: 'username', type: "fake", "placeholder":"Email address"}).value("@<b>"+user.username+"</b>")
			)
			.row(
				Form.label({label: "Job title", sublabel: "Job title"}),
				Form.input({name: 'title', "placeholder":"Job title"}).value(user.title)
			)
			.row(
				Form.label({label: "Profile image", sublabel: "Profile image"}),
				Form.input({name: 'image', type: 'file', "placeholder":"&rarr; View your profile image"}).value((user.image.length)?user._image:null)
			)
			.row(
				Form.label({label: "Date of birth", sublabel: "Your date of birth"}),
				Form.inputGroup([Form.input({name: 'dob_day', "placeholder":"Day", role:"dob_day", type: "select", options: dates}).value(user.dob.day), 
				   Form.input({name: 'dob_month', "placeholder":"month", role:"dob", type: "select", options: months}).value(user.dob.month),
				   Form.input({name: 'dob_year', "placeholder":"year", role:"dob", type: "select", options: years}).value(user.dob.year)
				]) 
			)
			.row(
				Form.label({label: "Phone number", sublabel: "Primary phone number"}),
				Form.input({name: 'phone', "placeholder":"Primary phone number"}).value(user.phone)
			)
			.row(
				Form.label({label: "Current address", sublabel: "Current address"}),
				Form.input({name: 'address', type:"textarea", "placeholder":"Current address"}).value(user.address)
			)
			.hiddens({'username': username})
			.buttons([
				 {label: "Edit account info", action: function(){
					 Form.submit("edit-profile-fx", function(code){
						 if (!code.good()){
							 return AP.alertError(code.message);
						 }
					
						 Form.hide("edit-profile-fx");
						 // AP.alertSuccess(code.message);
						 UI.flash("Edited successfully");
						 AP.refresh();
					 });
				 }, style: 'ok -success -rounded bold'},
				 {label: "Cancel", action: function(){
					 Form.hide("edit-profile-fx");
				 }, style:'cancel -passive-2 -rounded'}
			]).settings();
		
			Form.pop({id:'edit-fx-dx', width: 720, label: 'Edit account info of @'+username}).setForm(form).show();
			
		});
	};
	
	
	
	
	this.editManager=function(username){
		var user=People.get(username);
		
		var form=Form.create('edit-profile-fx',{'action':'api/company/user.manager'})
		.row(
			Form.label({label: "Manager", sublabel: "The direct manager"}),
			Form.input({name: 'manager', type: "text", "placeholder":"Type to select manager", role: "tag"}).value(user.manager)
		)
		.hiddens({
			username: username
		})
		.render(function($f){
			$f.find("manager").focus();
		})
		.buttons([
			 {label: "Set manager", action: function(){
				 Form.submit("edit-profile-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("edit-profile-fx");
					 // AP.alertSuccess(code.message);
					 UI.flash("Editted successfully");
					 AP.refresh();
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("edit-profile-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id:'edit-fx-dx', width: 480, label: 'Set managers for '+user.name}).setForm(form).show();
		
	};
	
	
	
	this.createAccount=function(){
		var form=Form.create('create-account-fx',{action: 'api/company/account/create'})
		.row(
			Form.label({label: "Họ &amp; tên đệm *",sublabel: "Họ &amp; tên đệm"}),
			Form.input({name: 'last_name', "placeholder":"Họ & tên đệm"})
		)
		.row(
			Form.label({label: "Tên *",sublabel: "Tên tài khoản"}),
			Form.input({name: 'first_name', "placeholder":"Tên tài khoản"})
		)
		.row(
			Form.label({label: "Username *",sublabel: "<span class='red'>Username của tài khoản sẽ không thể thay đổi - vui lòng lựa chọn username phù hợp.</span>"}),
			Form.input({name: 'username', "placeholder":"Username", render:"<div class='input-render'>http://"+Client.system.domain+"/</div>"})
		)
		.row(
			Form.label({label: "Email *",sublabel: "Một mật khẩu tạm thời sẽ được gửi đến email này."}),
			Form.input({name: 'email', "placeholder":"Email tài khoản"})
		)
		.row(
			Form.label({label: "Chức danh",sublabel: "Chức danh, chức vụ hoặc vị trí trong công ty"}),
			Form.input({name: 'title', "placeholder":"Chức danh, chức vụ hoặc vị trí"})
		)
		.row(
			Form.label({label: "Phân quyền sử dụng",sublabel: "Phân quyền sử dụng hệ thống"}),
			Form.input({name: 'priv', type: "select", options:[{label: "Thành viên thông thường", value: "member"}, {label: "System admin - Quản trị", value: "admin"}, {label: "System owner - Quản trị cấp cao", value: "owner"}]})
		)
		.hiddens(
			{
				token:Client.system.token
			}
		)
		.buttons([
			 {label: "Tạo tài khoản mới", action: function(){
				 Form.submit("#create-account-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-account-fx");
					 AP.alertSuccess("Tài khoản đã được tạo thành công.", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-account-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 600, label: 'Tạo tài khoản mới'}).setForm(form).show();
		
	};
	
	
	
	
	this.createNetwork = function(parent_id){
		if (!parent_id){
			parent_id=0;
		}
		
		var form=Form.create('create-team-fx',{action: 'api/company/team/create'})
		.row(
			Form.label({label: "Tên nhóm *",sublabel: "The group name"}),
			Form.input({name: 'name', "placeholder":"The user group name"})
		)
		.row(
			Form.label({label: "Directory *",sublabel: "The relative directory from your domain <i>"+Client.system.domain+"</i>"}),
			Form.input({name: 'path', "placeholder":"Team directory", render:"<div class='input-render'>http://"+Client.system.domain+"/</div>"})
		)
		.row(
			Form.label({label: "Group owner *",sublabel: "Please select the user group's owner"}),
			Form.input({name: 'leader', "placeholder":"The group owner", role:"user"})
		)
		.row(
			Form.label({label: "Các thành viên khác *",sublabel: "People can be added to the business unit later on."}),
			Form.input({name: 'users', "placeholder":"Type @ to tag and add people to this business unit", role:"tag"})
		)
		.rowHidden(
			Form.label({label: "Membership", sublabel: "How people can view and join the group?"}),
			Form.input({name: 'type', 'type':'list', options: [
				{value: 1, "label":"Public membership", "sublabel":"Everyone can see the team and join"},
				{value: 3, "label":"Restricted membership", "sublabel":"The team is invisible to everyone and people outside can join by invitation only"}
			]}).value(3)
		)
		.rowHidden(
			Form.label({label: "Phòng ban cấp trên *", sublabel: "Select the parent business unit in the organization chart"}),
			Form.input({name: 'parent', 'type':'select', options: Company.chart.asOptions(null, function(e){
				if (e.metatype=="me"){
					return false;
				}
				return true;
			})}).value(parent_id)
		)
		.row(
			Form.label({label: "Giới thiệu thêm",sublabel: "Short description about the user group"}),
			Form.input({name: 'about', 'type':'textarea', "placeholder":"Short description about the user group"})
				.css({height: '80px'})
		)
		.render(function(fobj){
		})
		.hiddens({
			token:Client.system.token
		})
		.buttons([
			 {label: "Create user group", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.alertSuccess("A new user group was just created", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 600, label: 'Create a new user group'}).setForm(form).show();
		
	};
	
	
	
	this.checkUserQuota=function(){
		if (Client.quota_alert){
			$("#quota-alert").html("<div class='box'>Số lượng tài khoản trên hệ thống đã/sắp vượt qua giới hạn cho phép của <b>"+Client.system.name+"</b> (<b>"+Client.quota_alert.limit+"</b> tài khoản). Vui lòng <a href='https://"+Client.domain+"/private/upgrade' target='_blank'>nâng cấp tài khoản</a> để tạo thêm thành viên.</div>");
		}
	}
	
};



"<@require sa.js>";
"<@require token.js>";
"<@require media.js>";