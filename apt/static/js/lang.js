var Lang=new function _Lang(){	
	this.privacy={"public":0, "private":1};
	
	var _message={
		"Mật khẩu còn trống.":"Your password is empty.",
		"Bỏ qua":"Cancel",
		"Thêm câu hỏi mới":"Ask question"
	};
	
	this.message=function(msg){
		if (_message[msg]){
			return _message[msg];
		}
		return "?"+msg+"";
	};
	
};


/**
 * @desc Procedural calls of lang.
 * @param key
 * @param flag
 */
function lang(key, flag){
	return key;
	
	if (!flag){
		flag=null;
	}
	var msg=Lang.message(key);
	if (flag=='ucf'){
		return AP.W.ucf(msg);
	}
	if (flag=='ucw'){
		return AP.W.ucw(msg);
	}
	if (flag=='upper'){
		return AP.W.upper(msg);
	}
	return msg;
};

function L(key){
	var lang=parseInt(Client.lang);
	if (lang==2){
		return Lang.message(key);
	}else{
		return key;
	}
};



