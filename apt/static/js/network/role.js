var Role=new function __Role(){
	
	this.OWNER=13;
	this.ADMIN = 10;
	this.REGULAR=1;
	this.BLOCKED=-1; 
	
	this.lists=[
		 	{id: 13, key:'owner', name:'Team Owner'},
		 	{id: 10, key:'admin', name:'Admin'},
		 	{id: 1, key:'member', name:'Member'},
		 	{id: -1, key:'blocked', name:'Blocked Member'},
		];
};





Role.collection=new function __RoleCollection(){
	this.get=function(id){
		id=parseInt(id);
		for (var i=0; i<Role.lists.length; i++){
			if (Role.lists[i].id==id){
				return Role.lists[i]; 
			}
		}
		
		return {id: 0, key:'unknown', name:'Unknown Role'};
	};
};