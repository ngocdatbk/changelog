Me.app=new function __MeApp(){
	this.mailTo=function(username){
		var form=UI.form('peer-mail-fx',{'action':'api/me/mail/send'})
		.warning("You will send an email directly to @"+username+"'s email through this form.")
		.row(
			UI.label({label: "Email subject",sublabel: "you want to send"}),
			UI.input({name: 'name', "placeholder":"The email subject"})
		)
		.row(
			UI.label({label: "Email content",sublabel: "the email content"}),
			UI.input({name: 'content', type:'textarea', "placeholder":"The content of the email"}).css({height: '200px'})
		)
		.hiddens({
			"username": username
		})
		.buttons([
			 {label: "Send email to @"+username, action: function(){
				 UI.submitForm("peer-mail-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
					 
					 UI.hideForm("peer-mail-fx");
					
					 UI.flash("Message sent");
					 
				 });
			 }, style: 'ok success rounded bold'},
			 {label: "Cancel", action: function(){
				 UI.hideForm("peer-mail-fx");
			 }, style:'cancel passive-3 rounded'}
		]).settings();
	
		UI.popForm({id:'peer-mail-fx-dx', width: 720, label: icon("envelop")+'Send email to @'+username+' via '+CONFIG.name}).setForm(form).show().focus('name');
	};
	
};