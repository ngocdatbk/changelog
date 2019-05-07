var Changelog=new function __ProductTool(){
	this.create=function(){
		var products = Client.pageData.products;

		var actions=AP.select(products, function(e){
			e.label=e.name;
			e.sublabel="";
			return e;
		});


		AP.selectAction(actions, function(act){
			var form=Form.create('create-product-fx',{action: 'api/changelog/create'})
				.row(
					Form.label({label: "Product name",sublabel: ""}),
					Form.input({name: 'product_name', "placeholder":"Product name"}).value(act.name)
				)
				.row(
					Form.label({label: "Version",sublabel: "Current " + act.current_version}),
					Form.input({name: 'version', "placeholder":"Version"})
				)
				.row(
					Form.label({label: "Changelog name",sublabel: ""}),
					Form.input({name: 'title', "placeholder":"Changelog name"})
				)
				.row(
					Form.label({label: "Changelog detail",sublabel: ""}),
					Form.input({name: 'content', placeholder:"", id: 'content', type: 'textarea', role: 'editor'}).css({height: 80})

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
								AP.alertSuccess("Changelog đã được tạo thành công.", function(){
									AP.refresh();
								});
							});
						}, style: 'ok -success -rounded -bold'},
					{label: "Cancel", action: function(){
							Form.hide("create-product-fx");
						}, style:'cancel -passive-2 -rounded'}
				]).settings();

			Form.pop({id: 'create-product-fx-dx', width: 600, label: 'New changelog'}).setForm(form).show();

		},{title: "Select product", filter: true});
		//
		// UI.editor("#content");
	};
};



"<@require sa.js>";
"<@require token.js>";
"<@require media.js>";