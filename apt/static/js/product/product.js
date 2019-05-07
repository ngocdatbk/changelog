var Product=new function __ProductTool(){
	var subscribed = false;

	this.create=function(){
		var form=Form.create('create-product-fx',{action: 'api/product/create'})
		.row(
			Form.label({label: "Changelog name *",sublabel: ""}),
			Form.input({name: 'name', "placeholder":"Changelog name"})
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
					 AP.alertSuccess("Changelog đã được tạo thành công.", function(){
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

	this.display=function(products){
		var html=AP.render(products, getProductHTML);
		$("#product-list tbody").html(html);
	};

	function getProductHTML(e){
		var subscribed = AP.array.findObj(e.subscribers,  Client.viewer.id) ? "subscriber" : '';
		var writers="";
		if (e.writers && e.writers.length){
			for (var i=0; i < e.writers.length && i < 10; i++){
				var m=e.writers[i];
				if (m && parseInt(m.id)){
					writers+="<div class='user -g'>" +
						"	<div class='icon url std' data-username='"+m.username+"'><div class='avatar'><span class='image'><img src='"+AP.xthumb(m.gavatar)+"'/></span></div></div>" +
						"</div>";
				}
			}

			if (e.writers.length >10) {
				writers+="<div class='user -g'>" +
					"	<div class='icon std' ><div class='avatar'><span class='image'>10+</span></div></div>" +
					"</div>";
			}
		}

		return `
		<tr class='js-product'>
			<td>
				<div class='product' data-name='${e.name}' data-subscribed='${subscribed}'>
					<div class='icon url'><div class='avatar'>
						<span class='image'><img src=''/></span>
					</div></div>
					<div class='text'>
						<b class='std pname'>${e.name}</b>
						<div class='sub ap-xdot'>Created ${AP.i18n.date(e.since)} by ${e.username}</div>
					</div>
				</div>
			</td>
			<td>${e.current_version}</td>
			<td>${writers}</td>
			<td>${e.num_subscribers}</td>
			<td>&nbsp;</td>
		</tr>`;
	};

	this.filter=function(query){
		if ((!query || !query.length) && !subscribed){
			$("#product-list .js-product").show();
		} else if (!subscribed) {
			query=query.toLowerCase();

			$("#product-list .js-product").each(function(){
				var name=$(this).find(".product").data('name').toLowerCase();

				if (name.indexOf(purify(query))>=0){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		} else if (!query || !query.length) {
			$("#product-list .js-product").each(function(){
				if ($(this).find(".product").data('subscribed')){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		} else {
			query=query.toLowerCase();

			$("#product-list .js-product").each(function(){
				var name=$(this).find(".product").data('name').toLowerCase();

				if (name.indexOf(purify(query))>=0 && $(this).find(".product").data('subscribed')){
					$(this).show();
				}else{
					$(this).hide();
				}
			});
		}
	};;

	this.filterSubscribed=function(fsubscribed){
		subscribed = fsubscribed;

		$('#product-search-ip').val('');
		this.filter('');
	};
};



"<@require sa.js>";
"<@require token.js>";
"<@require media.js>";