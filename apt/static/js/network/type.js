Network.type=new function __NetworkType(){
	this.types={
		'head':13,
		'root':13,
		'office_public':1,
		'office_private':2,
		'office_restriced':3
	};
	
	this.typeName=function(type){
		if (AP.data.equal(type, this.types.head)){
			return "Head office";
		}
		
		if (AP.data.equal(type, this.types.office_public)){
			return "Public office";
		}
		
		if (AP.data.equal(type, this.types.office_private)){
			return "Private office";
		}
		
		return "Restricted office";
	};
};