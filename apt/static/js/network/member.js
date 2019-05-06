Network.member=new  function __WnetworkMember(){
	this.invite=function(ref){
		Form.submitFrom(ref, function(code){
			if (!code.good()){
   			 return AP.alertError(code.message);
   		 }
   		 
   		 AP.alertSuccess(code.message);
		});
	};
	
	
	this.inviteDialog=function(){
		var form=Form.create('d-invite-fx',{'action':'api/network/member/invite'})
		.row(
			Form.noLabel(),
			Form.input({name: 'usernames', "type":"text", "placeholder":"Type @ to tag all people you want to invite"})
		)
		.hiddens({
			network: Client.data.network.id,
			'token': Client.data.network.token
		})
		.buttons([
			 {label: "Invite to "+Client.data.network.name, action: function(){
				 Form.submit("d-invite-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("d-invite-fx");
					 return AP.alertSuccess("Invite people successfully", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("d-invite-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings({"block": true});
	
		Form.pop({id:'d-invite-fx-dx', width: 600, 
			label: "Invite people to "+Client.data.network.name
		}).setForm(form).show().focus('usernames');
		
		Tag.user(form.find('usernames'), Client.people);
	};
	
};