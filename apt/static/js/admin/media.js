Admin.media=new function __AdminMedia(){
	this.render=function(){
		$("#js-medialist tr.js-item").each(function(){
			var name=$(this).data("name");
			var id=$(this).data("id");
			
			var preview="";
			if (Client.pageData.media[id]){
				var url=Client.pageData.media[id];
				preview="<a target='_blank' href='"+url+"'>Preview</a>";
			}
			
			$(this).html("<td><b>"+name+"</b></td>" +
				"<td>"+preview+"</td>" +
				"<td>" +
				"	<div class='buttons'>" +
				"		<div class='button js-upload'>Upload</div>" +
				"		<div class='button js-remove'>Remove</div>" +
				"	</div>" +
				"</td>");
			
			$(this).find(".js-remove").click(function(){
				var mid=$(this).closest("tr").data("id");
				AP.confirm("Are you sure to remove this resource?", function(){
					UI.ajaxShow();
					AP.post("api/company/media/remove",{id: mid}, function(code){
						UI.ajaxHide();
						
						if (!code.good()){
							return AP.alertError(code.message);
						}
						
						UI.flash("Remove successfully ...");
						AP.xRefresh();
					});
				});
			});
			
			
			AP.uploadable($(this).find(".js-upload"),{
				action: "api/company/media/upload",
				data: {id: id},
				name: "image"
			}, function(code){
				if (!code.good()){
					return AP.alertError(code.message);
				}
				
				UI.flash("Update successfully");
				AP.xRefresh();
			})
		});
	};
};