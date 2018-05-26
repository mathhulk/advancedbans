
class Configuration {
	
	constructor(path) {
		$.getJSON(path, function(data) {
			this.configuration = data;
		});
	}
	
	value( ) {
		/*
		Not working at the moment
		
		var path = Array.from(arguments);
		
		if(path.length === 0) {
			return false;
		} else {
			while(path.length > 0) {
				if(index) {
					index = index[path.shift()];
				} else {
					var index = this.configuration[path.shift()]
				}
			}
			return index;
		}
		*/
	}
	
	get dictionary( ) {
		return this.configuration;
	}
	
}