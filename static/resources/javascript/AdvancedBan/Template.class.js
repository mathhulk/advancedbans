class Template {
	
	constructor(template, indices, callback) {
		__templates[template] = this;
		
		$.get("static/templates/external/" + template + ".txt", function(data) {
			__templates[template].template = data;
			
			for(let i = 0; i < indices.length; i++) indices[i] = "{{ " + indices[i] + " }}";
			
			__templates[template].indices = indices;
			
			callback( );
		});
	}
	
	set template(template) {
		this._template = template;
	}
	
	/*
	get template( ) {
		return this._template;
	}
	*/
	
	set indices(indices) {
		this._indices = indices;
	}
	
	/*
	get indices( ) {
		return this._indices;
	}
	*/
	
	replace(indices) {
		let template = this._template;
		
		for(let i = 0; i < indices.length; i++) template = template.replace(new RegExp(this._indices[i], "g"), indices[i]);
		
		return template;
	} 
	
}