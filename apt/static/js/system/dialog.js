var WTAjaxDialogEngine=new function __WTAjaxDialogEngine(){
	
	this.canvas=function(){
		return $("#apdialogs");
	};
	
	/**
	 * @desc Render the dialog.
	 */
	this.render=function(dialog){	
		$(dialog.canvas()).append("" +
			"<div class='__wtajaxdialog' id='"+dialog.w(true)+"'>" +
				"<div class='__dialogwrapper'>" +
					"<div class='__dialogwrapper-inner'>" +
						"<div class='__dialogmain'>" +
							"<div class='__dialogtitle'>"+"&nbsp;</div>"+
							"<div class='__dialogcontent'><span style='font-size:32px' class='ficon-spinner ficon-spin'></span> <p>Processing</p></div>" +
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>");
	};
	
	
	/**
	 * @desc Balancing the dialog.
	 */
	this.balance=function(dialog){
		var wid=dialog.w();
		var t=$(window).height()/2- $(wid+' .__dialogwrapper').outerHeight(true)/2-45;
		var l=$(window).width()/2- $(wid+' .__dialogwrapper').outerWidth(true)/2;
		if (t<50){
			t=50;
		}
		
		$(wid+' .__dialogwrapper').css('top', t).css('left', l);
	};
};





var WTDialogEngine=new function __DialogEngine(){
	this.canvas=function(){
		return $("#apdialogs");
	};
	
	/**
	 * @desc Render the dialog.
	 */
	this.render=function(dialog){	
		$(dialog.canvas()).append("" +
			"<div class='__wtdialog' id='"+dialog.w(true)+"'>" +
				"<div class='__dialogwrapper'>" +
					"<div class='__dialogwrapper-inner'>" +
						"<div class='__dialogmain'>" +
							"<div class='__dialogtitle unselectable' onclick=\"AP.dialog('"+dialog.id()+"').balance();\">"+"&nbsp;</div>"+
							"<div class='__dialogclose' onclick=\"AP.dialog('"+dialog.id()+"').hide();\"><span class='-ap icon-close'></span> </div>"+
							"<div class='__dialogcontent'></div>" +
							"<div class='__dialogbuttons unselectable'></div>"+
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>");
	};
	
	
	/**
	 * @desc Balancing the dialog.
	 */
	this.balance=function(dialog){
		var wid=dialog.w();
		var t=$(window).height()/2- $(wid+' .__dialogwrapper').outerHeight(true)/2-30;
		var l=$(window).width()/2- $(wid+' .__dialogwrapper').outerWidth(true)/2;
		if (t<50){
			t=50;
		}
		
		$(wid+' .__dialogwrapper').css('top', t).css('left', l);
		$(wid+' .__dialogwrapper .__buttons .button:last').focus();
	};
};









var FormDialogEngine=new function __FormDialogEngine(){
	this.canvas=function(){
		return $("#apdialogs");
	};
	
	/**
	 * @desc Render the dialog.
	 */
	this.render=function(dialog){	
		$(dialog.canvas()).append("" +
			"<div class='__fdialog' id='"+dialog.w(true)+"'>" +
				"<div class='__dialogwrapper'>" +
					"<div class='__dialogwrapper-inner'>" +
						"<div class='__dialogmain'>" +
							"<div class='__dialogtitlewrap'><div class='left relative'><div class='__dialogtitle unselectable ap-xdot' onclick=\"AP.dialog('"+dialog.id()+"').balance();\">"+"&nbsp;</div><div class='__dialogtitlerender tx-fill'></div></div> <div class='clear'></div></div>"+
							"<div class='__dialogclose' onclick=\"AP.dialog('"+dialog.id()+"').hide();\"><span class='-ap icon-close'></span> </div>"+
							"<div class='__dialogcontent'></div>" +
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>");
	};
	
	
	/**
	 * @desc Balancing the dialog.
	 */
	this.balance=function(dialog){
		var wid=dialog.w();
		var t=$(window).height()/2- $(wid+' .__dialogwrapper').outerHeight(true)/2-30;
		var l=$(window).width()/2- $(wid+' .__dialogwrapper').outerWidth(true)/2;
		if (t<50){
			t=50;
		}
		
		$(wid+' .__dialogwrapper').css('top', t).css('left', l);
		$(wid+' .__dialogwrapper .__buttons .button:last').focus();
	};
};






var FormDialogEngine2=new function __FormDialogEngine(){
	this.canvas=function(){
		return $("#apdialogs");
	};
	
	/**
	 * @desc Render the dialog.
	 */
	this.render=function(dialog){	
		$(dialog.canvas()).append("" +
			"<div class='__fdialog' id='"+dialog.w(true)+"'>" +
				"<div class='__dialogwrapper'>" +
					"<div class='__dialogwrapper-inner'>" +
						"<div class='__dialogmain'>" +
							"<div class='__dialogtitlewrap nd'><div class='__dialogtitle unselectable' onclick=\"AP.dialog('"+dialog.id()+"').balance();\"></div></div>"+
							"<div class='__dialogclose' onclick=\"AP.dialog('"+dialog.id()+"').hide();\"><span class='-ap icon-close'></span> </div>"+
							"<div class='__dialogcontent'></div>" +
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>");
	};
	
	
	/**
	 * @desc Balancing the dialog.
	 */
	this.balance=function(dialog){
		var wid=dialog.w();
		var t=$(window).height()/2- $(wid+' .__dialogwrapper').outerHeight(true)/2-30;
		var l=$(window).width()/2- $(wid+' .__dialogwrapper').outerWidth(true)/2;
		if (t<50){
			t=50;
		}
		
		$(wid+' .__dialogwrapper').css('top', t).css('left', l);
		$(wid+' .__dialogwrapper .__buttons .button:last').focus();
	};
	
	
	
};







var FormDialogMobile=new function __FormDialogMobile(){
	this.canvas=function(){
		return $("#apdialogs");
	};
	
	
	/**
	 * @desc Render the dialog.
	 */
	this.render=function(dialog){	
		$(dialog.canvas()).append("" +
			"<div class='__mobiledialog' id='"+dialog.w(true)+"'>" +
				"<div class='__dialogwrapper'>" +
					"<div class='__dialogwrapper-inner'>" +
						"<div class='__dialogmain'>" +
							"<div class='__dialogclose' onclick=\"AP.dialog('"+dialog.id()+"').hide();\"><span class='-ap icon-close'></span> </div>"+
							"<div class='__dialogtitle unselectable ap-xdot'>"+"</div>" +
							"<div class='__dialogcontent'></div>" +
						"</div>"+
					"</div>"+
				"</div>"+
			"</div>");
	};
	
	
	/**
	 * @desc Balancing the dialog.
	 */
	this.balance=function(dialog){
		return this;
	};
	
	
	this.width=function(w){
		return;
	};
};