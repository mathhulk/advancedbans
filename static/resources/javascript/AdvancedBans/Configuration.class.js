class Configuration {
	
	constructor(path, callback) {
		let pseudo = this;
		
		$.getJSON(path, function(data) {
			pseudo.collection = data;
			
			callback( );
		});
		
		return this;
	}
	
	set collection(collection) {
		this._collection = collection;
	}
	
	get collection( ) {
		return this._collection;
	}
	
	get(indices) {
		let value = this._collection[indices.shift( )];
		
		for(let i = 0; i < indices.length; i++) value = value[indices[i]];
		
		return value;
	}
	
}