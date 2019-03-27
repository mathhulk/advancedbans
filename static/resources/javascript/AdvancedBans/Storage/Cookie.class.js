class Cookie {
	
	static initialize(prefix) {
		this._prefix = prefix;
	}
	
	static get prefix( ) {
		return this._prefix;
	}
	
	static get(cookie) {
		let cookies = decodeURIComponent(document.cookie).split(";");
		
		for(let i = 0; i < cookies.length; i++) {
			let selection = cookies[i];
			
			while(selection.charAt(0) === " ") selection = selection.substring(1);
			
			if(selection.indexOf(this._prefix + "_" + cookie + "=") === 0) return selection.substring((this._prefix + "_" + cookie + "=").length, selection.length);
		}
		
		return false;
	}
	
	static set(cookie, value) {
		let date = new Date( );
		date.setTime(date.getTime( ) + 3600 * 3600);
		
		document.cookie = this._prefix + "_" + cookie + "=" + value + "; " + date.toUTCString( ) + "; path=/";
	}
	
	static remove(cookie) {
		let date = new Date( );
		date.setTime(date.getTime( ) - 3600 * 3600);
		
		document.cookie = this._prefix + "_" + cookie + "= ; " + date.toUTCString( ) + "; path=/";
	}
	
}