var UploadDialogEngine=new function __UploadDialogEngine(){
	inherits(this, WTDialogEngine);
	
	/**
	 * @desc Render the dialog.
	 */
	this.render=function(dialog){		
		$(dialog.canvas()).append("" +
			"<div class='__uploaddialog unselectable' id='"+dialog.w(true)+"'>" +
				"<div class='__dialogwrapper'>" +
					"<div class='__dialogwrapper-inner'>" +
						"<div class='__dialogmain'>" +
							"<div class='__dialogtitle'>"+"&nbsp;</div>"+
							"<div class='__dialogclose' onclick=\"$('#"+dialog.data('form')+"').multiUpload('close');\"><div class='entypo ticon-cancel'></div> </div>"+
							"<div class='__dialogcontent'></div>" +
							"<div class='__dialogbuttons unselectable'></div>"+
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>");
	};
};