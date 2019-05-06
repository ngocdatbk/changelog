Me.note=new function __MeNote(){
	this.create=function(){
		this.form(function(note){
			Note.canvas.insert("#my-notes", note);
		});
	};
	
	
	this.form=function(){
		var hiddens={user: Client.data.user.id};;
		
		var form=UI.form('note-fx',{'action':'api/me/note/create'})
			.row(
				UI.noLabel(),
				UI.input({name: 'name', "type":"text", "placeholder":"Set a title for the note"})
			)
			.row(
				UI.noLabel(),
				UI.input({name: 'content', "type":"textarea", "placeholder":"The content of the note you want to share"}).css({height: 320})
			)
			.row(
				UI.label({label: "Choose a color", "sublabel": "Pick a color to highlight the note"}),
				UI.input({name: 'color', type:"colors", options:[
					{value:"1", label: "<div class='square box-fill-alt-1'><div class='square-in'></div></div>"},
					{value:"2", label: "<div class='square box-fill-alt-2'><div class='square-in'></div></div>"},
					{value:"3", label: "<div class='square box-fill-alt-3'><div class='square-in'></div></div>"},
					{value:"4", label: "<div class='square box-fill-alt-4'><div class='square-in'></div></div>"},
					{value:"5", label: "<div class='square box-fill-alt-5'><div class='square-in'></div></div>"},
					{value:"6", label: "<div class='square box-fill-alt-6'><div class='square-in'></div></div>"},
					{value:"7", label: "<div class='square box-fill-alt-7'><div class='square-in'></div></div>"},
					{value:"8", label: "<div class='square box-fill-alt-8'><div class='square-in'></div></div>"},
					{value:"9", label: "<div class='square box-fill-alt-9'><div class='square-in'></div></div>"},
					{value:"10", label: "<div class='square box-fill-alt-10'><div class='square-in'></div></div>"},
					{value:"11", label: "<div class='square box-fill-alt-11'><div class='square-in'></div></div>"},
				]}).value(1)
			)
			.hiddens(hiddens)
			.buttons([
				 {label: "Save note", action: function(){
					 Live.lock();
					 UI.submitForm("note-fx", function(code){
						 if (!code.good()){
							 return AP.alertError(code.message);
						 }
						 
						 UI.hideForm("note-fx");
						 UI.flash("Note created");
						 Note.canvas.insert("#my-notes",code.note);
						 
					 });
				 }, style: 'ok success rounded bold'},
				 {label: "Cancel", action: function(){
					 UI.hideForm("note-fx");
				 }, style:'cancel passive-3 rounded'}
			]).settings({block: true});
		
		UI.popForm({id:'note-fx-dx', width: 600, label: icon("entypo ticon-docs")+'Create a note'}).setForm(form).show().focus('name');
	};

	this.displayLabels=function(){
		var html=AP.render(Client.pageData.note_labels, function(item){
			if (item.name && Client.pageData.params && Client.pageData.params.tag && item.name==Client.pageData.params.tag){
				return "<div class='li url active' data-url='@me/notes/tag/"+item.name+"'># "+item.name+"</div>";
			}else{
				return "<div class='li url' data-url='@me/notes/tag/"+item.name+"'># "+item.name+"</div>";	
			}
		});
		
		$("#note-labels .w").html(html);
	};
};