class Language {
	
	static initialize(discriminator, callback) {
		$.getJSON("static/languages/" + discriminator + ".json", function(data) {
			Language.language = data.language;
			Language.collection = data.collection;
			
			Language.discriminator = discriminator;
			
			callback( );
		});
	}
	
	static set language(language) {
		this._language = language;
	}
	
	/*
	static get language( ) {
		return this._language;
	}
	*/
	
	static set collection(collection) {
		this._collection = collection;
	}
	
	/*
	static get collection( ) {
		return this._collection;
	}
	*/
	
	static set discriminator(discriminator) {
		this._discriminator = discriminator;
	}
	
	static get discriminator( ) {
		return this._discriminator;
	}
	
	static get(term, standard) {
		return this._collection[term] ? this._collection[term] : standard;
	}
	
}