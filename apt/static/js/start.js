// Require Configuration [Required]
AP.config.dialog={};
AP.config.dialog.engine=WTDialogEngine;
AP.config.alertDialogEngine=WTDialogEngine;
AP.config.uploadDialogEngine=UploadDialogEngine;
AP.config.ajaxAlertDialogEngine=WTAjaxDialogEngine;
AP.config.theme=0;


// Translate error messages [Required]
AP.error.messages=AP.data.assoc()
	.add(AP.error.code.CONFLICT_DATA, "Bad input. Please try again")
	.add(AP.error.code.INVALID_DATA, "Invalid data. Please try again.")
	.add(AP.error.code.INCOMPLETE_DATA, "Your submitted data is incomplete. Please try to complete all required fields.")
	.add(AP.error.code.INVALID_USER, "Authentication error. You may not be able to perform this action.")
	.add(AP.error.code.INVALID_AUTHENTICATION, "Invalid authentication. Please try again.")
	.add(AP.error.code.LOGIN_REQUIRED, "Please login to perform this action.")
	.add(AP.error.code.DB_ERROR, "Unexpected error (1). Please contact us for further information.")
	.add(AP.error.code.SV_ERROR, "Unexpected error (2). Please contact us for further information.")
	.add(AP.error.code.INVALID_PASSWORD, "Invalid password. Please try again.")
	.add(AP.error.code.INVALID_EMAIL, "Invalid or empty email. Please try again.")
	.add(AP.error.code.INVALID_USERNAME, "Invalid username. Please try again.")
	.add(AP.error.code.INVALID_CHARACTER, "Some characters you enter are not allowed. Please try again.")
	.add(AP.error.code.INVALID_CAPTCHA, "Invalid captcha security code. Please try again.")
	.add("BAD_XCODE","Your session was expired. Please refresh the page (press F5) to continue.")
	.add("FORCE_REDIRECT","Your session was expired. Please refresh the page (press F5) to continue.")
	.add("DUPLICATED EMAIL","Email bị trùng lặp vì đã đăng ký trong hệ thống trước đó.")
	.assoc();








/**
 * @desc Startup document
 */

$(document).ready(function(){
	AP.add('ap-root','ap-temp', 'ap-apps','overlay','alert','ap-data');
	$("<div id='ap-invs'></div>").appendTo(document.body);
	AP.initContinuousRequest();
	AP.setContinuousRequest();
	AP.html.init();
	documentInit();
	
	if (Client.people){
		for (var i=0; i<Client.people.length; i++){
			Client.people[i].value="@"+Client.people[i].username;
			Client.people[i].sub=Client.people[i].first_name+" "+Client.people[i].last_name;
		}
	}
	
});


function mapready(){
	AP.sys.release('mapready');
};