var TwoFactor=new function __TwoFactor(){
	
	this.init=function(){
		if (Client.viewer.tfa.status){
			$("#m_2factor .body").show();
		}
		
		$("#js-2factor-status").on("change", function(){
			var val=$(this).val();
			
			if (!parseInt(val)){
				UI.ajaxShow();
				AP.post("api/me/twofactor", {status: val}, function(code){
					UI.ajaxHide();
					if (!code.good()){
						return AP.alertError(code.message);
					}
					
					UI.flash("Updated successfully");
					AP.refresh();
				});	
			}else{
				$("#js-code-verify").show();
				$("#m_2factor .body").show();
				$("#js-code-verify input").focus();
			}
		}).val(Client.viewer.tfa.status);
	};
	
	
	this.activate=function(activate){
		var val=$("#js-code-verify input").val();
		
		UI.ajaxShow();
		AP.post("api/me/twofactor", {status: val, verifier: val}, function(code){
			UI.ajaxHide();
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			UI.flash("Updated successfully");
			AP.refresh();
		});
	};
	
	
};