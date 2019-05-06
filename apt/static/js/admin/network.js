var NetworkMng=new function __NetworkMng(){
	this.display=function(networks){
		var temp=AP.array.filter(networks, function(e){
			if (e.metatype=="user" || e.metatype=="group"){
				return false;
			}
			
			if (Query.get("s")=="mine"){
				if (Me.isMemberOf(e)){
					return true;
				}
				
				return false;
			}
			
			return true;
		});
		
		var html=AP.render(temp, getNetworkHTML);
		$("#network-list").html(html);
		
		$("#mngheader .tab").setActiveURL();
	};
	
	this.filter=function(query){
		if (!query || !query.length){
			$("#people-list > .li").show();
			return;
		}
		
		query=query.toLowerCase();
		
		$("#network-list > .li").each(function(){
			var name=$(this).find(".text b.username").text().toLowerCase();
			var username=$(this).find(".text .sub b").text().toLowerCase();
			
			if (name.indexOf(query)>=0 || username.indexOf(query)>=0){
				$(this).show();
			}else{
				$(this).hide();
			}
		});
	};
	
	
	
	
	function getNetworkHTML(e, index, total){
		$.log(e);
		var priv="Created on "+UI.simpleTime(e.since);
		var eclass="";
		
		
		var priv="Company";
		if (e.metatype=="unit"){
			priv="<b class='text-success'>Business unit</b>";
			eclass+=" -unit";
		}else if (parseInt(e.role)==10){
			priv="<b>Group</b>";
			eclass+=" -group";
		}
		
		priv=___(e.about, "Không có miêu tả");
		var num_people=AP.array.count(Client.people, function(e){
			return e.metatype!="guest";
		});
		
		var leader=People.get(e.leader.username);
		var stats="<div class='sub ap-xdot'><b>"+e.num_people+"</b> thành viên &nbsp;&middot;&nbsp; Tạo vào lúc "+UI.simpleTime(e.since)+"</div>";
		if (e.metatype=="root" || e.metatype=="company"){
			stats="<div class='sub ap-xdot'><b>"+num_people+"</b> thành viên &nbsp;&middot;&nbsp; Main company</div>";
		}
		
		return "<div class='li -icon-left unselectable"+eclass+"' data-path='"+e.path+"' data-id="+e.id+">" +
			"	<div class='icon'><div class='count'>"+AP.data.zeroPrefix(index+1)+"</div></div>" +
			"	<div class='text ap-xdot'>" +
			"		<b class='url std' data-url='company/g/"+e.path+"'>"+e.name+"</b>" +
			"		<div class='sub ap-xdot'>@<b class=''>"+e.path+"</b> &nbsp;&middot;&nbsp; "+priv+"</div>"+
					stats +
			"	</div>" +
			"	<div class='leader url' style='display:none' data-url='account/"+leader.username+"'>" +
			"		<div class='avatar avatar-40 -circled'><div class='image'><img src='"+AP.xthumb(leader.gavatar)+"'/></div></div>" +
			"		<div class='label'>Leader</div>" +
			"		<div class='li ap-xdot name'>"+leader.name+"</div>" +
			"		<div class='li ap-xdot info'>"+leader.title+"</div>" +
			"	</div>"+
			"	<div class='action -more pointer url' data-url='company/g/"+e.path+"'></div>" +
			"</div>";
	};
};