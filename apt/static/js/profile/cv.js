Profile.cv=new function __ProfileCV(){
	this.find=function(type, id){
		if (!Client.pageData.cv[type]){
			return null;
		}
		
		
		var obj=Client.pageData.cv[type];
		
		return AP.array.find(obj, function(elem){
			return elem.id==id;
		});
	}
	
	this.add=function(type, values){
		var opt={
			"title": "Thêm thông tin học vấn",
			"rows":
				[
					{name: "name", label: "Tên trường *", "type":"text"},
					{name: "major", label: "Chuyên ngành *", "type":"text"},
					{name: "time", label: "Thời gian (bắt đầu - kết thúc) *", "type":"text"},
			]
		};
		
		if (type=='work'){
			opt={
					"title": "Thêm thông tin công việc &amp; nghề nghiệp",
					"rows":
						[
							{name: "name", label: "Tên tổ chức / doanh nghiệp *", "type":"text"},
							{name: "position", label: "Vị trí hoặc vai trò *", "type":"text"},
							{name: "time", label: "Thời gian (bắt đầu - kết thúc)", "type":"text"},
							{name: "desc", label: "Thông tin thêm", "type":"textarea"}
					]
				};
		}
		

		if (type=='award'){
			opt={
					"title": "Thêm thông tin giải thưởng hoặc thành tích",
					"rows":
						[
							{name: "name", label: "Tên giải thưởng hoặc thành tích *", "type":"text"},
							{name: "time", label: "Thời điểm *", "type":"text"},
							{name: "desc", label: "Thông tin thêm", "type":"textarea"}
					]
				};
		}
		
		showForm(opt, type, values);
	};
	
	
	this.edit=function(ref, dir){
		var $item=$(ref).closest(".item");
		var id=$item.data("id");
		var type=$item.data("type");
		var row=this.find(type, id);
		
		if (!row){
			return;
		}
		
		this.add(type, row);
	};
	
	
	this.editLinks=function(id){
		var data={};
		if (id){
			data.id=id;
		}
		
		var form=Form.create('create-team-fx',{action: 'api/user/edit.links'})
		.row(
			Form.label({label: "Website cá nhân"}),
			Form.input({name: 'homepage'}).value(Client.pageData.cvlinks.homepage)
		)
		.row(
			Form.label({label: "Facebook URL"}),
			Form.input({name: 'facebook'}).value(Client.pageData.cvlinks.facebook)
		)
		.row(
			Form.label({label: "Linkedin URL"}),
			Form.input({name: 'linkedin'}).value(Client.pageData.cvlinks.linkedin)
		)
		.row(
			Form.label({label: "Twitter URL"}),
			Form.input({name: 'twitter'}).value(Client.pageData.cvlinks.twitter)
		)
		.render(function(fobj){
			setTimeout(function(){
				fobj.focus('homepage');
			},300);
		})
		.hiddens(data)
		.buttons([
			 {label: "Hoàn thành", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.refresh();
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 600, label: 'Liên kết mạng xã hội', layout: 'flat'}).setForm(form).show();
	};
	
	
	
	this.editContact=function(id){
		var data={};
		if (id){
			data.id=id;
		}
		
		var form=Form.create('create-team-fx',{action: 'api/user/edit.contact'})
		.row(
			Form.label({label: "Số điện thoại công ty"}),
			Form.input({name: 'office_phone'}).value(Client.pageData.contact.office_phone)
		)
		.row(
			Form.label({label: "Số điện thoại nhà"}),
			Form.input({name: 'home_phone'}).value(Client.pageData.contact.home_phone)
		)
		.row(
			Form.label({label: "Skype username / number"}),
			Form.input({name: 'skype'}).value(Client.pageData.contact.skype)
		)
		.row(
			Form.label({label: "Viber username / number"}),
			Form.input({name: 'viber'}).value(Client.pageData.contact.viber)
		)
		.row(
			Form.label({label: "Whatsapp username / number"}),
			Form.input({name: 'whatsapp'}).value(Client.pageData.contact.whatsapp)
		)
		.row(
			Form.label({label: "Zalo username / number"}),
			Form.input({name: 'zalo'}).value(Client.pageData.contact.zalo)
		)
		.render(function(fobj){
			setTimeout(function(){
				fobj.focus('company_phone');
			},300);
		})
		.hiddens(data)
		.buttons([
			 {label: "Hoàn thành", action: function(){
				 Form.submit("#create-team-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-team-fx");
					 AP.refresh();
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-team-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-team-fx-dx', width: 600, label: 'Thông tin liên hệ', layout: 'flat'}).setForm(form).show();
	};
	
	
	
	this.move=function(ref, dir){
		var $item=$(ref).closest(".item");
		var id=$item.data("id");
		var type=$item.data("type");
		
		UI.ajaxShow();
		AP.post("api/me/profile/cv.move",{id: id, type: type, dir: dir}, function(code){
			UI.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			moveElement($item, dir);
		});
	};
	
	
	
	this.remove=function(ref, dir){
		var $item=$(ref).closest(".item");
		var id=$item.data("id");
		var type=$item.data("type");
		
		UI.ajaxShow();
		AP.post("api/me/profile/cv.remove",{id: id, type: type, action: 'remove'}, function(code){
			UI.ajaxHide();
			
			if (!code.good()){
				return AP.alertError(code.message);
			}
			
			UI.flash("Remove successfully ...");
			$item.slideUp(300);
		});
	};
	
	
	function showForm(opt, type, values){
		var hiddens={'type': type};
		if (Client.pageData.user && Client.pageData.user.id){
			hiddens.id=Client.pageData.user.id;
		}
		
		var cta="Thêm";
		
		if (values && values.id){
			hiddens.id=values.id;
			cta="Sửa";
		}
		
		var form=Form.create('edit-profile-fx',{'action':'api/user/cv.edit'});
		for (var i=0; i<opt.rows.length; i++){
			var r=opt.rows[i];
			if (r.type=="textarea"){
				form.row( 
						Form.label({label: r.label}),
						Form.input({name: r.name, type: r.type}).css({height: 100})
				);	
			}else{
				form.row(
						Form.label({label: r.label}),
						Form.input({name: r.name, type: r.type})
				);
			}
		}
		
		form.hiddens(hiddens)
		.buttons([
			 {label: cta, action: function(){
				 Form.submit("edit-profile-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("edit-profile-fx");
					 
					 UI.flash("Edited successfully");
					 AP.xRefresh();
				 });
			 }, style: 'ok -success -rounded bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("edit-profile-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).render(function(fobj){
			if (values && values.id){
				for (var i=0; i<opt.rows.length; i++){
					fobj.find(opt.rows[i].name).val(values[opt.rows[i].name]);
				}
			}
			
			setTimeout(function(){
				fobj.focus(opt.rows[0].name);
			},300);
		});
	
		Form.pop({id:'edit-profile-dx', width: 600, label: opt.title, layout: 'flat'}).setForm(form).show();
		
	};
	
	
	function moveElement($item, dir){
		if (dir=="up"){
			var $x=$item.prev();
			if (!$x.length || !$x.hasClass("item")){
				return;
			}
			$x.insertAfter($item);
		}else{
			var $x=$item.next();
			if (!$x.length || !$x.hasClass("item")){
				return;
			}
			$x.insertBefore($item);
		}
	};
};