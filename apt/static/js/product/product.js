var Product=new function __ProductTool(){
	this.create=function(){
		var form=Form.create('create-product-fx',{action: 'api/product/create'})
		.row(
			Form.label({label: "Product name *",sublabel: ""}),
			Form.input({name: 'name', "placeholder":"Product name"})
		)
		.row(
			Form.label({label: "Current version *",sublabel: ""}),
			Form.input({name: 'current_version', "placeholder":"Current version"})
		)
		.row(
			Form.label({label: "Who can write change log *",sublabel: ""}),
			Form.input({name: 'writers', "placeholder":"@username", role:"tag"})
		)
		.row(
			Form.label({label: "Subscribers",sublabel: "Who will get notified"}),
			Form.input({name: 'subscribers', "placeholder":"@username, @team or @all", role:"tag"})
		)
		.hiddens(
			{
				token:Client.system.token
			}
		)
		.buttons([
			 {label: "Save", action: function(){
				 Form.submit("#create-product-fx", function(code){
					 if (!code.good()){
						 return AP.alertError(code.message);
					 }
				
					 Form.hide("create-product-fx");
					 AP.alertSuccess("Product đã được tạo thành công.", function(){
						 AP.refresh();
					 });
				 });
			 }, style: 'ok -success -rounded -bold'},
			 {label: "Cancel", action: function(){
				 Form.hide("create-product-fx");
			 }, style:'cancel -passive-2 -rounded'}
		]).settings();
	
		Form.pop({id: 'create-product-fx-dx', width: 600, label: 'New product'}).setForm(form).show();
		
	};
};



"<@require sa.js>";
"<@require token.js>";
"<@require media.js>";