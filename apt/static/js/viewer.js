/**
 * @desc Viewer Object
 */
var Viewer = new function _Viewer(){
	
	inherits(this, APViewer);

	
	this.editAccount=function(){
		AP.dialog("#account-edit-dx").temp(false).button($("#account-edit-dx").data("ok"), function(){
			Viewer.exeAccountEdit();
		},'ss').button($("#account-edit-dx").data("cancel"), function(){
			AP.dialog("#account-edit-dx").hide();
		}).show();
	};
	
	
	this.exeAccountEdit=function(){
		AP.submit("#account-edit-fx", function(code){
			if (!code.good()){
				return AP.alertError(code.message);
			}
			AP.alertSuccess(code.message, function(){
				AP.refresh();
			});
		});
	};
	
	
	this.editPassword=function(){
		AP.dialog("#password-edit-dx").temp(false).button($("#password-edit-dx").data("ok"), function(){
			Viewer.exePasswordEdit();
		},'ss').button($("#password-edit-dx").data("cancel"), function(){
			AP.dialog("#password-edit-dx").hide();
		}).show();
	};
	
	
	this.exePasswordEdit=function(){
		AP.submit("#password-edit-fx", function(code){
			if (!code.good()){
				return AP.alertError(code.message);
			}
			AP.alertSuccess(code.message, function(){
				AP.refresh();
			});
		});
	};
};