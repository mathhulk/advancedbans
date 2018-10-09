class Configuration {
	
	static initialize(callback) {
		$.getJSON("static/configuration.json", function(data) {
			Configuration.collection = data;
			
			callback( );
		});
	}
	
	static set collection(collection) {
		this._collection = collection;
	}
	
	/*
	static get collection( ) {
		return this._collection;
	}
	*/
	
	static get(indices) {
		let value = this._collection[indices.shift( )];
		
		for(let i = 0; i < indices.length; i++) value = value[indices[i]];
		
		return value;
	}
	
}