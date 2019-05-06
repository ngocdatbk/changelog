Me.info=new function __WUserInfo(){
	this.edit=function(){
		AP.ajaxShow();
		AP.post("api/me/info", {}, function(code){
			console.log(code);
			AP.ajaxHide();
			if (!code.good()){
				return;
			}
			
			var dates=range(1,31);
			dates.unshift({label: "-- Chọn ngày --", value: 0});
			
			var months=range(1,12);
			months.unshift({label: "-- Chọn tháng --", value: 0});
			
			var years=range(2010,1930);
			years.unshift({label: "-- Chọn năm --", value: 0});
			
			
			var user=code.user;
			
			var form=Form.create('edit-profile-fx',{'action':'api/me/edit'})
			.row(
				Form.label({label: "First name",sublabel: "The first name"}),
				Form.input({name: 'first_name', "placeholder":"First name"}).value(user.first_name)
			)
			.row(
				Form.label({label: "Last name",sublabel: "The last name"}),
				Form.input({name: 'last_name', "placeholder":"Last name"}).value(user.last_name)
			)
			.row(
				Form.label({label: "Email", sublabel: "Your email address"}),
				Form.input({name: 'email', type: "fake", "placeholder":"Email address"}).value(user.email)
			)
			.row(
				Form.label({label: "Username", sublabel: "Your username"}),
				Form.input({name: 'username', type: "fake", "placeholder":"Email address"}).value("@<b>"+user.username+"</b>")
			)
			.row(
				Form.label({label: "Job title", sublabel: "Your job title"}),
				Form.input({name: 'title', "placeholder":"Job title", readOnly:  (!Me.isSystemAdmin() && Client.system.settings.title=="no") }).value(user.title)
			)
			.row(
				Form.label({label: "Profile image", sublabel: "Your profile image"}),
				Form.input({name: 'image', type: 'file', "placeholder":"&rarr; View your profile image"}).value((user.image.length)?user._image:null)
			)
			.row(
				Form.label({label: "Date of birth", sublabel: "Your date of birth"}),
				Form.inputGroup([Form.input({name: 'dob_day', "placeholder":"Day", role:"dob_day", type: "select", options: dates}).value(Client.viewer.dob.day), 
				   Form.input({name: 'dob_month', "placeholder":"month", role:"dob", type: "select", options: months}).value(Client.viewer.dob.month),
				   Form.input({name: 'dob_year', "placeholder":"year", role:"dob", type: "select", options: years}).value(Client.viewer.dob.year)
				]) 
			)
			.row(
				Form.label({label: "Phone number", sublabel: "Your primary phone number"}),
				Form.input({name: 'phone', "placeholder":"Primary phone number"}).value(user.phone)
			)
			.row(
				Form.label({label: "Current address", sublabel: "Your current address"}),
				Form.input({name: 'address', type:"textarea", "placeholder":"Your current address"}).value(user.address)
			)
			.buttons([
				 {label: "Edit personal profile", action: function(){
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
		
			Form.pop({id:'edit-fx-dx', width: 720, label: 'Edit personal profile'}).setForm(form).show();
			
			
		});
		
	};
	
	
	
	this.editPassword = function(){
		var form=Form.create('edit-profile-fx',{'action':'api/me/edit.password'})
		.row(
			Form.label({label: "Current password",sublabel: "Your current password"}),
			Form.input({name: 'password', "type":"password", "placeholder":"Current password"})
		)
		.row(
			Form.label({label: "New password",sublabel: "Your new password"}),
			Form.input({name: 'new_password', "type":"password", "placeholder":"New password"})
		)
		.row(
			Form.label({label: "Retype new pasword", sublabel: "Repeat your new password"}),
			Form.input({name: 'new_password2', type: "password", "placeholder":"Retype your new password"})
		)
		.row(
			Form.label({label: "Force logout", sublabel: "Force logout from all devices"}),
			Form.input({name: 'force_logout', type: "select", options:[{label:"No", value:0}, {label:"Yes", value:1}]}).value(1)
		)
		.note("Notice: Change your password may force you to logout of every mobile device")
		.buttons([
			 {label: "Change password", action: function($this){
				 Form.submit("edit-profile-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
					 
					 Form.hide("edit-profile-fx");
					 AP.alertSuccess("Password was updated successfully");
					 AP.refresh();
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("edit-profile-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id:'edit-fx-dx', width: 480, label: 'Change account password'}).setForm(form).show();
		
	};
	
	
	
	
	this.editLanguage = function(){
		var form=Form.create('edit-profile-fx',{'action':'api/me/edit.language'})
		.row(
			Form.label({label: "Tùy chọn ngôn ngữ",sublabel: "Change display language"}),
			Form.input({name: 'lang', "type":"select", options: [{label:"Tiếng Việt | Vietnamese", value:"vi"}, {label:"Tiếng Anh | English", value:"en"}]}).value(Client.viewer.lang)
		)
		.buttons([
			 {label: "Change language", action: function($this){
				 Form.submit("edit-profile-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
					 
					 Form.hide("edit-profile-fx");
					 AP.alertSuccess("Language preference updated successfully");
					 AP.refresh();
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("edit-profile-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id:'edit-fx-dx', width: 420, label: 'Change account language'}).setForm(form).show();
		
	};
	

	
	
	
	this.editSocial=function(){
		AP.ajaxShow();
		AP.post("api/me/info", {}, function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				return;
			}
			
			var user=code.user;
			
			var form=Form.create('edit-profile-fx',{'action':'api/me/edit.social'})
			.row(
				Form.label({label: "Homepage",sublabel: "Your personal homepage"}),
				Form.input({name: 'website', "placeholder":"Your personal homepage"}).value(user.social.website)
			)
			.row(
				Form.label({label: "Facebook",sublabel: "Your facebook profile link"}),
				Form.input({name: 'facebook', "placeholder":"Your Facebook profile link"}).value(user.social.facebook)
			)
			.row(
				Form.label({label: "Linkedin",sublabel: "Your Linkedin profile link"}),
				Form.input({name: 'linkedin', "placeholder":"Your Linkedin profile link"}).value(user.social.linkedin)
			)
			.row(
				Form.label({label: "Twitter",sublabel: "Your Twitter profile link"}),
				Form.input({name: 'twitter', "placeholder":"Your Twitter profile link"}).value(user.social.twitter)
			)
			.row(
				Form.label({label: "Skype",sublabel: "Your Skype username"}),
				Form.input({name: 'skype', "placeholder":"Your Skype username"}).value(user.social.skype)
			)
			.buttons([
				 {label: icon("lock",14)+ "Update social profiles", action: function(){
					 Form.submit("edit-profile-fx", function(code){
						 if (!code.good()){
							 return AP.alertError(code.message);
						 }
						 
						 AP.alertSuccess("Your profile was updated successfully", function(){
							 AP.xRefresh();
						 });
						 Form.hide("edit-profile-fx");
					 });
				 }, style: 'ok -success -rounded bold'},
				 {label: "Cancel", action: function(){
					 Form.hide("edit-profile-fx");
				 }, style:'cancel -passive-2 -rounded'}
			]).settings();
		
			Form.pop({id:'edit-fx-dx', width: 600, label: 'Update social profiles'}).setForm(form).show();
		});
	};
	
	
	this.editAdvanced=function(){
		AP.ajaxShow();
		AP.post("api/me/info", {}, function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				return;
			}
			
			var user=code.user;
			var about="";
			if (user.about && user.about.length){
				about=user.about.toTextarea();
			}
			
			var form=Form.create('edit-profile-fx',{'action':'api/me/edit.advanced'})
			.row(
				Form.label({label: "About me",sublabel: "Describe yourself in a few sentences"}),
				Form.input({name: 'aboutme', "placeholder":"Describe yourself in a few sentences", type: "textarea"}).value(about).css({height: 150})
			).rowHidden(
				Form.label({label: "Education",sublabel: "Your most recent school or university"}),
				Form.input({name: 'education', "placeholder":"Your most recent school or university"})
			).row(
				Form.label({label: "Interests",sublabel: "Your list of interests"}),
				Form.input({name: 'interests', "placeholder":"List of your interests"}).value(user.interests)
			).buttons([
				 {label: "Save now", action: function(){
					 Form.submit("edit-profile-fx", function(code){
						 if (!code.good()){
							 return AP.alertError(code.message);
						 }
						 AP.alertSuccess("Your profile was updated successfully.", function(){
							 AP.xRefresh();
						 });
						 Form.hide("edit-profile-fx");
					 });
				 }, style: 'ok -success -rounded bold'},
				 {label: "Cancel", action: function(){
					 Form.hide("edit-profile-fx");
				 }, style:'cancel -passive-2 -rounded'}
			]).settings();
			
			Form.pop({id:'edit-fx-dx', width: 640, label:'Edit about-me and other personal information'}).setForm(form).show(); 
		});
	};
	
	
	this.editUnit = function(){
		AP.ajaxShow();
		
		if(!Me.isSystemAdmin()) {
			return;
		}
		
		if(Client.system.path != 'daily' && Client.system.path != 'uni') {
			return;
		}
		
		AP.post("api/me/info.mog", {}, function(code){
			AP.ajaxHide();
			if (!code.good()){
				return;
			}
			
			var user = code.user;
			
			var form = Form.create('edit-profile-fx',{'action':'api/me/edit.mogunit'})
			.row(
				Form.label({label: "Chức vụ", sublabel: "Chức danh của thành viên trong công ty"}),
				Form.input({name: 'title', "placeholder":"Chức vụ"}).value(user.title)
			)
			.row(
				Form.label({label: "Phòng ban", sublabel: "Đơn vị làm việc"}),
				Form.input({name: 'mog_unit_code', type: 'select', options: code.mog_unit_options}).value(user.mog_unit_code)
			)
			.buttons([
				 {label: "Sửa thông tin đơn vị", action: function(){
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
		
			Form.pop({id:'edit-fx-dx', width: 720, label: 'Sửa thông tin đơn vị'}).setForm(form).show();
			
			
		});
		
	};
};