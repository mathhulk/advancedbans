class Language {
	
	constructor(discriminator, callback) {
		let pseudo = this;
		
		$.getJSON("static/languages/" + discriminator + ".json", function(data) {
			pseudo.language = data.language;
			pseudo.collection = data.collection;
			
			pseudo.discriminator = discriminator;
			
			callback( );
		});
		
		return this;
	}
	
	set language(language) {
		this._language = language;
	}
	
	get language( ) {
		return this._language;
	}
	
	set collection(collection) {
		this._collection = collection;
	}
	
	get collection( ) {
		return this._collection;
	}
	
	set discriminator(discriminator) {
		this._discriminator = discriminator;
	}
	
	get discriminator( ) {
		return this._discriminator;
	}
	
	get(term, standard) {
		return this._collection[term] ? this._collection[term] : standard;
	}
	
}