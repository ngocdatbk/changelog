var Account=new function __Account(){
	
	this.login=function(ref){
		var $form=$(ref).closest("form");
		
		$('input[name="appkey"]', $form).val(Query.get("app"));
		
		AP.ajaxShow();
		
		
		AP.submit("#"+$form.attr('id'), function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				if (!code.good()){
					if (code.message=="ERROR_2FA_EMPTY"){
						$(".js-2fa").show();
						setTimeout(function(){
							$(".js-2fa input").focus();
						}, 200);
						
						return;
					}
					
					return AP.alertError(code.message);
				}
				
				return AP.alertError(code.message);
			}
			
			if (typeof code.appkey !== 'undefined') {
				var http="http";
				if (Client.https){
					http="https";
				}
				var url = http+'://' + code.appkey + '.' + Client.domain;
				var path=Query.get("path");
				if (!path || !path.length){
					path=Query.get("return");
				}
				
				if (path){
					AP.redirect(url+"/"+path);
				}else{
					AP.redirect(url);	
				}
				
			} else {
				AP.redirect("account");
			}
		});
	};
	
	
	
	this.join=function(ref){
		var $form=$(ref).closest("form");
		
		AP.ajaxShow();
		
		AP.submit("#"+$form.attr('id'), function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			AP.toURL("account");
		});
	};
	
	
	this.setup=function(ref){
		var $form=$(ref).closest("form");
		
		AP.ajaxShow();
		
		AP.submit("#"+$form.attr('id'), function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			AP.toURL("account");
		});
	};
	
	

	this.recover=function(ref){
		var $form=$(ref).closest("form");
		AP.ajaxShow();
		AP.submit("#"+$form.attr('id'), function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			AP.alertSuccess("We have sent you an email with instruction about how to recover your password. Please open your email to proceed.");
		});
	};
	
	
	
	
	this.resetPassword=function(ref){
		var $form=$(ref).closest("form");
		AP.ajaxShow();
		AP.submitFrame("#"+$form.attr('id'), function(code){
			AP.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			AP.alertSuccess("Password reset successfully.", function(){
				AP.redirect("home");
			});
		});
	};
};