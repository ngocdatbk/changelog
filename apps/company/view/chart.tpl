<script>

// Online.loaded(function(){
	UI.orgchart.display(Company.chart.getRoot(), "#org-chart", function(e){
		var eclass="";
		var leader=e.leader;
		if (Online.online(leader)){
			eclass=" -online";
		}
		
		return "<div class='org url' data-url='company/g/"+e.path+"'>"+
			"<div class='avatar avatar-40"+eclass+"'><div class='image'><img src='"+AP.xthumb(e.leader.image)+"'/></div></div>"+
			"<div class='name'>"+e.name+"</div>"+
			"<div class='info ap-xdot'>Managed by @"+e.leader.username+"</div>"+
			"<div class='info ap-xdot'>"+e.num_people+" members</div>"+
		"</div>"+
		"<div class='add' title='Add node' onclick=\"Admin.createNetwork('"+e.id+"');\"><div><span class='-ap icon-add'></span></div></div>";
	},{
		width: 200,
		height:80,
		space: 40,
		button: true,
		mousewheel: true
	});

	AP.html.resize(function(){
		var h=$(window).height()-97;
		if (h<500){
			h=500;
		}
		$("#org-chart").css("height", h);
	}); 

	$("#appheader .menu .tab").setActive(".tab-chart");
// });

</script>

{% view ~chart/header.tpl}

<div style='position:relative; background-color:#fff; margin:10px 5px;'  id='org-chart'>
	
</div>