var SV=new function __SideView(){
	this.__on=false;
	
	this.enabled=function(){
		return this.__on;
	};
	
	this.canvas=function(){
		return $("#sideview .__canvas");
	};
	
	this.display=function(width){
		$("#sideview").animate({"width": width, "right": 0}, 300);
		$("#pagew").animate({"right": width}, 300).addClass("__sided");
		this.__on=true;
		
		return this;
	};
	
	this.show=function(width){
		return this.display(width);
	};
	
	this.hide=function(){
		$("#sideview").css("right",-1000).css("width", 500).removeClass().find(".__canvas").html("");
		$("#pagew").css("right", 0).removeClass("__sided");
		this.__on=false;
		
		return this;
	};
	
	this.addClass=function(classname){
		return $("#sideview").addClass(classname);
	}
};