var PeopleMng=new function __PeopleMng(){
	this.info=function(username, callback){
		AP.ajaxShow();
		AP.post("api/user/info", {username: username}, function(code){
			AP.ajaxHide();
			if (!code.good()){
				return;
			}
			
			callback(code.user);
		});
	};
	
	
	this.display=function(users){
		if (!users){
			users=Client.people;
		}
		
		var html=AP.render(users, getPersonHTML);
		$("#people-list tbody").html(html);
		
		fixCounters(users);
		
		var tab=Query.get("tab");
		if (tab && tab.length){
			PeopleMng.show(tab, true);
		}
		
		
		Online.loaded(function(){
			Online.reorder(users);
			var html=AP.render(users, getPersonHTML);
			$("#people-list tbody").html(html);
			
			fixCounters(users);
			
			var tab=Query.get("tab");
			if (tab && tab.length && tab!="all"){
				PeopleMng.show(tab, true);
			}else if (tab && tab=="all"){
				PeopleMng.show("", true);
				$("#mngheader .tab").setActive(0);
			}
		});
		
	};
	
	this.displayDeactivated=function(users){
		if (!users){
			users=Client.people;
		}
		
		var html=AP.render(users, getDeactivatedHTML);
		$("#people-list tbody").html(html);
		
		$("#mngheader .tab").setActive(3);
		$("#mngheader .tab").click(function(){
			var tab=$(this).data("tab");
			if (tab){
				AP.toURL("company?tab="+tab);
			}
		})
	};
	
	
	
	this.show=function(tab, inline){
		
		if (!tab){
			tab=Query.get("tab");
		}
		
		$("#mngheader .menu .tab").setActive(".tab-"+tab);
		
		if (Client.path.current=="company/chart" && !inline){
			if (tab=="chart"){
				return AP.toURL("company/chart");
			}else{
				return AP.toURL("company?tab="+tab);
			}
		}
		
		
		if (tab=="online"){
			clearSearch();
			$("#people-list .js-user").hide();
			$("#people-list .js-user.-online").show();
		}else if (tab=="admins"){
			clearSearch();
			$("#people-list .js-user").hide();
			$("#people-list .js-user.-admin").show();
			$("#people-list .js-user.-owner").show();
		}else if (tab=="chart" && !inline){
			AP.toURL("company/chart");
		}else{
			clearSearch();
			$("#people-list .js-user").show();
		}
	};
	
	
	this.filter=function(query){
		if (!query || !query.length){
			$("#people-list .js-user").show();
			return;
		}
		
		query=query.toLowerCase();
		
		$("#people-list .js-user").each(function(){
			var name=$(this).find(".text b.url").text().toLowerCase();
			var username=$(this).find(".text .sub b").text().toLowerCase();
			name=purify(name+" " +username);
			
			if (name.indexOf(purify(query))>=0){
				$(this).show();
			}else{
				$(this).hide();
			}
		});
	};
	
	
	
	this.selectOptions=function(ref, username){
		var edit_by_admin=[];
		
		if (Client.data.network && Me.isNetworkOwner(Client.data.network) && username!=Client.viewer.username){
			edit_by_admin=[
			{label: 'Make @<b>'+username+'</b> a regular member', icon:"icon-star-empty", action: function(){Admin.ms.makeMember(username);}},
			{label: 'Grant @<b>'+username+'</b> admin access', icon:"icon-star-half", action: function(){Admin.ms.makeAdmin(username);}},
		   	{label: 'Grant @<b>'+username+'</b> owner access', icon:"icon-star", action: function(){Admin.ms.makeOwner(username);}},	
			];
			
			
			if (Client.data.network.metatype=="root" || Client.pageData.network.metatype=="root"){
			}else{
				edit_by_admin.push({label: 'Remove @<b>'+username+'</b> from this team', icon:"icon-uniF11F", action: function(){Admin.ms.revoke(username);}});	
			}
		}else if (Me.isSystemOwner() && username!=Client.viewer.username){
			edit_by_admin=[
				{label: 'Make @<b>'+username+'</b> a regular member', icon:"icon-star-empty", action: function(){Admin.ms.makeMember(username);}},
   				{label: 'Grant @<b>'+username+'</b> admin access', icon:"icon-star-half", action: function(){Admin.ms.makeAdmin(username);}},
   		   		{label: 'Grant @<b>'+username+'</b> owner access', icon:"icon-star", action: function(){Admin.ms.makeOwner(username);}},	
   			];
			
			if (Client.pageData.network && Client.pageData.network.metatype=="root"){
				
			}else{
				edit_by_admin.push({label: 'Remove @<b>'+username+'</b> from this team', icon:"icon-uniF11F", action: function(){Admin.ms.revoke(username);}});	
			}
		}
		
		if (Me.isSystemOwner()){
			edit_by_admin.push({'type' :'sep'});
			edit_by_admin.push({label: "Set custom IP range", "icon":"icon-security", action: function(){Admin.sa.setUserIPRange(username, $(ref).data("ips"));}});
			edit_by_admin.push({label: "Grant special access", "icon":"icon-shield", action: function(){Admin.sa.edit(username);}});
			edit_by_admin.push({label: "Change user email", "icon":"icon-mail2", action: function(){Admin.sa.setUserEmail(username)}});
			edit_by_admin.push({label: "Set a new password", "icon":"icon-lock2", action: function(){Admin.sa.setUserPassword(username)}});
			edit_by_admin.push({label: "Disable 02-factor authentication", "icon":"icon-unlocked", action: function(){Admin.sa.disable2FA(username);}});
		}
		
		if (Me.isSystemAdmin()){
			edit_by_admin.push({'type' :'sep'});
			edit_by_admin.push({label: "Chỉnh sửa tài khoản của @<b>"+username+"</b>", "icon":"icon-mode_edit", action: function(){Admin.edit(username);}});
			edit_by_admin.push({label: "Chỉnh sửa/ chọn direct manager", "icon":"icon-mode_edit", action: function(){Admin.editManager(username);}});
		}
		
		if (Me.isSystemOwner() && Client.viewer.username!=username){
			edit_by_admin.push({'type' :'sep'});
			
			var user=AP.array.single(Client.pageData.people, function(e){
				return e.username==username;
			});
			
			if (user && parseInt(user.status)==-1){
				edit_by_admin.push({label: "Reactivate tài khoản này", "icon":"icon-ion-ios-checkmark", action: function(){Admin.reactivate(username);}});	
			}else{
				edit_by_admin.push({label: "Deactivate tài khoản này", icon:"icon-stop3", action: function(){Admin.deactivate(username);}});	
			}
		}
		
		if (edit_by_admin.length){
			return Context.menu(ref, {top: 30, left:-240, menu: edit_by_admin});
		}else{
			return Context.menu(ref, {top: 30, left:-240, menu: [
	 			{label: 'Xem profile của @<b>'+username+'</b>', 'icon': 'icon-profile icm', action: 'user/'+username},
	 			{label: 'Chat với @<b>'+username+'</b>', 'icon': 'icon-bubble2', action: function(){
	 				Base.message.peer(username, {'from': 'context'});
	 				Context.hide();
	 			}}
	 		].concat(edit_by_admin)});	
		}
	};
	
	
	function fixCounters(users){
		var online=0;
		var admins=0;
		var owners=0;
		
		for (var i=0; i<users.length; i++){
			if (users[i].online){
				online++;
			}
			
			if (parseInt(users[i].role)==13){
				owners++;
			}else if (parseInt(users[i].role)==10){
				admins++;
			}
		}
		
		$("#mngheader .tab.tab-everyone .counter").html("("+users.length+"");
		$("#mngheader .tab.tab-online .counter").html("("+online+")");
		$("#mngheader .tab.tab-admins .counter").html("("+(admins+owners)+")");
	};
	
	
	function clearSearch(){
		$("#people-search-ip").val("");
	};
	
	
	
	function getPersonHTML(e){
		var priv="Member since "+AP.i18n.date(e.since);
		var status="";
		var eclass="";
		
		if (Online.online(e.username)){
			status=" -online";
			eclass=" -online";
		}
		
		var priv="";
		if (parseInt(e.ms.role)==13){
			priv="<b class='red'>Owner</b> &nbsp;&middot;&nbsp; ";
			eclass+=" -owner";
		}else if (parseInt(e.ms.role)==10){
			priv="<b class='red'>Admin</b> &nbsp;&middot;&nbsp; ";
			eclass+=" -admin";
		}
		
		var manager="";
		if (e.manager && e.manager.length){
			if (e.manager.length==1){
				var m=People.get(e.manager);
				if (m && parseInt(m.id)){
					manager="<div class='user'>" +
					"	<div class='icon url std' data-username='"+m.username+"'><div class='avatar'><span class='image'><img src='"+AP.xthumb(m.gavatar)+"'/></span></div></div>" +
					"	<div class='text'>" +
					"		<b class='url std' data-username='"+m.username+"'>"+m.name+"</b>" +
					"		<div class='sub'>@"+m.username+" &middot; "+m.title+"</div>" +
					"	</div>" +
					"</div>";	
				}
			}else{
				for (var i=0; i<e.manager.length; i++){
					var m=People.get(e.manager[i]);
					if (m && parseInt(m.id)){
						manager+="<div class='user -g'>" +
						"	<div class='icon url std' data-username='"+m.username+"'><div class='avatar'><span class='image'><img src='"+AP.xthumb(m.gavatar)+"'/></span></div></div>" +
						"</div>";
					}
				}
			}
		}else{
			manager="<div style='height:60px;' onclick=\"Admin.editManager('"+e.username+"');\"></div>";
		}
		
		var tfa="";
		if (Me.isSystemAdmin() && !mobile()){
			if (e.tfa_status && parseInt(e.tfa_status)){
				tfa=`<span class='tfa' title='Two-factor authentication enabled'><span class='ficon-shield text-success'></span></span>`;
			}else{
				tfa=`<span class='tfa' title='Two-factor authentication disabled'><span class='ficon-shield text-c'></span></span>`;
			}
		}
		
		var extra=`
			<td> 
				<div class='minfo list-info'> 
					<div class='li ap-xdot'>${e.email}</div> 
					<div class='li ap-xdot'>${___(e.phone,'<i class=\'opt-80\'>Phone number not set</i>')}</div>
					<div class='li ap-xdot'>${___(e.address,'<i class=\'opt-80\'>Address not set</i>')}</div>
					
				</div>
			</td>
			<td>${manager}</td>
		`;
		
		if (mobile()){
			extra=""; 
		}
		
		return `
		<tr class='li js-user unselectable${eclass}' data-username='${e.username}'>
			<td>
				<div class='user'>
					<div class='icon url' data-username='${e.username}'><div class='avatar ${status}'>
						<span class='image'><img src='${AP.xthumb(e.gavatar)}'/></span>
					</div></div>
					<div class='text'>
						<b class='url std' data-url='user/${e.username}'>${e.name}</b>
					 	<div class='sub ap-xdot'>@<b class=''>${e.username}</b> &nbsp;&middot;&nbsp; ${___(e.title,"<i>No title</i>")}</div>
						<div class='sub ap-xdot'>${priv}Member since ${AP.i18n.date(e.since)}</div>
					</div>
					
					${tfa}
				</div>
			</td>
			
			${extra}
			
			<td>
				<div class='action -more pointer' onclick="PeopleMng.selectOptions(this, \"${e.username}\");"></div>
			</td>
		</tr>`;
	};
	
	
	
	
	
	
	
	function getDeactivatedHTML(e){
		var priv="Member since "+AP.i18n.date(e.since);
		var status="";
		var eclass="";
		
		if (Online.online(e.username)){
			status=" -online";
			eclass=" -online";
		}
		
		var priv="Deactivated";
		
		var manager="";
		if (e.manager && AP.data.isArray(e.manager)){
			for (var i=0; i<e.manager.length; i++){
				var m=People.get(e.manager[i]);
				if (m && parseInt(m.id)){
					manager="<div class='user'>" +
					"	<div class='icon url std' data-username='"+m.username+"'><div class='avatar'><span class='image'><img src='"+AP.xthumb(m.gavatar)+"'/></span></div></div>" +
					"	<div class='text'>" +
					"		<b class='url std' data-username='"+m.username+"'>"+m.name+"</b>" +
					"		<div class='sub'>@"+m.username+" &middot; "+m.title+"</div>" +
					"	</div>" +
					"</div>";
				}
			}
		}else{
			// manager="<div style='height:60px;' onclick=\"Admin.editManager('"+e.username+"');\"></div>";
		}
		
		return "" +
		"<tr class='li js-user unselectable"+eclass+"' data-username='"+e.username+"'>" +
			"<td>" +
			"	<div class='user'>" +
				"	<div class='icon url' data-username='"+e.username+"'><div class='avatar "+status+"'><span class='image'><img src='"+AP.xthumb(e.gavatar)+"'/></span></div></div>" +
				"	<div class='text'>" +
				"		<b class='url std' data-url='user/"+e.username+"'>"+e.name+"</b>" +
				"		<div class='sub ap-xdot'>@<b class=''>"+e.username+"</b> &nbsp;&middot;&nbsp; "+___(e.title,"<i class='opt-80'>No title</i>")+"</div>" +
				"		<div class='sub ap-xdot'>"+priv+"Member since "+AP.i18n.date(e.since)+"</div>"+
				"	</div>" +
			"	</div>" +
			"</td>" +
			(!mobile()?
			("<td>" +
			"	<div class='minfo list-info'>" +
			"		<div class='li ap-xdot'>"+e.email+"</div>" +
			"		<div class='li ap-xdot'>"+___(e.phone,"<i class='opt-80'>Phone number not set</i>")+"</div>" +
			"		<div class='li ap-xdot'>"+___(e.address,"<i class='opt-80'>Address not set</i>")+"</div>" +
			"	</div>" +
			"</td>" +
			"<td>"+manager+"</td>"):"")+
			"<td>"+
			"	<div class='action -more pointer' onclick=\"PeopleMng.selectOptions(this, '"+e.username+"');\"></div>" +
			"</td>" +
		"</tr>";
	};
};










"<@require guest.js>";