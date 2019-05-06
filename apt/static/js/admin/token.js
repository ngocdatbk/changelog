Admin.token=new function __AdminToken(){
	
	this.create=function(){
		var form=Form.create('create-team-fx',{action: 'api/tokens/issue'})
		.row(
			Form.label({label: "App ID"}),
			Form.input({name: 'appkey', type: "text", placeholder: "For example: wework, request"})
		)
		.hiddens({
			token:Client.system.token,
		})
		.render(function($f){
		})
		.buttons([
			 {label: "Generate token", action: function(){
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
	
		Form.pop({id: 'create-team-fx-dx', width: 450, label: 'Issue new app token', layout: "block"}).setForm(form).show();
			
	};
	
	
	this.remove=function(ref){
		var id=$(ref).closest(".js-token").data("id");
		
		AP.confirm("Xác nhận xóa token này - Ứng dụng sử dụng token sẽ tự động bị khóa", function(){
			UI.ajaxShow();
			AP.post("api/tokens/remove",{id: id}, function(code){
				UI.ajaxHide();
				
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				AP.alertSuccess("Xóa thành công!", function(){
					AP.refresh();
				});
			});
		});
	};
	
	
	
	this.render=function(tokens){
		if (!tokens){
			return;
		}
		
		var html="";
		for (var i=0; i<tokens.length; i++){
			var e=tokens[i];
			
			html+="<tr class='js-token' data-id='"+e.id+"'>" +
				"<td><b>"+e.app+"</b></td>" +
				"<td><div class='textarea'><textarea>"+e.token+"</textarea></div></td>" +
				"<td><div>@"+e.issued_by+"<div></td>" +
				"<td><div class='actions'><div class='a action std normal' onclick='Admin.token.remove(this);'>Xóa token</div></div></td>" +
			"</tr>";
		}
		
		
		$("#js-tokenlist tbody").html(html);
	};
	
};