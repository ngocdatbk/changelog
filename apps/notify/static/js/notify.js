var Notify = new function __Notify(){
	function onRequestState(){
		var str=window.location.href;
		return (str.indexOf("request=1")!=-1);
	};
	
	
	this.listen=function(){
		window.addEventListener('message', function(e) {
			var org=e.origin;
			var domain=Client.domain;
			var ms=org.match(new RegExp('https?\:\/\/([a-zA-Z0-9]+)\.'+domain));
			if (!ms){
				return;
			}
			
			if (e && e.data && e.data.event=="int.perm.request"){
				Notify.executeNotificationRequest(function(code){
					parent.postMessage({
						event:"int.perm.result",
						p: code
					}, "*");
				});
				return;
			}
			
			var data = e.data;

		  	var notification = new Notification(data.title, data.options);
			notification.onclick=function(){
				parent.focus();
				parent.postMessage({
					event: "notis.indirect.click",
					refid: data.__refid
				}, data.__domain);
				
				this.close();
			};
			
			setTimeout(function(){
				if (notification){
					notification.close();
				}
			}, 5000);
		});
		
		parent.postMessage({
			event:"notis.perm",
			p: this.getPermission() 
		}, "*");
	};
	
	
	this.getPermission=function(){
		if (!("Notification" in window)){
			 return "denied";
		 }
		 
		
		 if (Notification.permission == "granted"){
			 return "granted";
		 }else if (Notification.permission == "denied"){
			 return "denied";
		 }else{
			 this.showRequestDialog();
			 return "pending";
		 }
	};
	
	
	
	this.showRequestDialog=function(){
		if (onRequestState()){
			if ('Notification' in window){
				 Notification.requestPermission(function (permission) {
					if (!('permission' in Notification)) {
						Notification.permission = permission;
					}
				  
					if (permission === "granted") {
						Clog.log("npe",1);
						//Okay, we are good
					}
					
					// Set cookie if necessary
					window.close();
				});
			 }	
		}
	};
	
	
	
	this.executeNotificationRequest=function(callback){
		if ('Notification' in window){
			 Notification.requestPermission(function (permission) {
				if (!('permission' in Notification)) {
					Notification.permission = permission;
				}
			  
				if (permission === "granted") {
					callback("granted");
					//Okay, we are good
				}else{
					callback("rejected");
				}
			});
		 }else{
			 callback("nosupport");
		 }
	};
};