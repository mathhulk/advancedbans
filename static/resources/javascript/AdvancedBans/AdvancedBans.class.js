class AdvancedBans {
	
	static initialize(callback) {
		this._page = 1;
		
		this._types = { };
		this._statuses = { };
		
		this._templates = { };
		
		this._reference = [
			[ "copied", ["copied"] ], 
			[ "copy", ["copy"] ], 
			[ "error-no-punishments", ["error_no_punishments"] ], 
			[ "page", ["status", "page", "text"] ], 
			[ "punishment", ["id", "type", "name", "reason", "operator", "date", "expires", "status"] ], 
			[ "time", ["time"] ], 
			[ "table", ["type", "name", "reason", "operator", "date", "expires", "status"] ]
		];
		
		Cookie.initialize("AdvancedBan");
		
		this._configuration = new Configuration("static/configuration.json", function( ) {
			
			AdvancedBans.language = new Language(Cookie.get("language") ? Cookie.get("language") : AdvancedBans.configuration.get(["default", "language"]), function( ) {
				
				AdvancedBans.loadTemplates(AdvancedBans.reference, 0, function( ) {
					
					if( AdvancedBans.configuration.get(["player_count", "enabled"]) ) {
						new ClipboardJS(".clipboard");
						
						AdvancedBans.setPlayers( );
						setInterval(AdvancedBans.setPlayers, 1000 * 10);
					}
					
					AdvancedBans.get(function( ) {
						callback( );
					});
				});
			});
		});
	}
	
	static get page( ) {
		return this._page;
	}
	
	static set page(page) {
		this._page = page;
	}
	
	static get types( ) {
		return this._types;
	}
	
	static set types(types) {
		this._types = types;
	}
	
	static addType(type) {
		this._types[type] = true;
	}
	
	static removeType(type) {
		delete this._types[type];
	}
	
	static get statuses( ) {
		return this._statuses;
	}
	
	static set statuses(statuses) {
		this._statuses = statuses;
	}
	
	static addStatus(status) {
		this._statuses[status] = true;
	}
	
	static removeStatus(status) {
		delete this._statuses[status];
	}
	
	static set templates(templates) {
		this._templates = templates;
	}
	
	static get templates( ) {
		return this._templates;
	}
	
	static setTemplate(template, content) {
		this._templates[template] = content;
	}
	
	static getTemplate(template) {
		return this._templates[template];
	}
	
	static loadTemplates(templates, position, callback) {
		
		AdvancedBans.setTemplate( templates[position][0], new Template(templates[position][0], templates[position][1], function( ) {
			
			if(position === templates.length - 1) callback( );
			else AdvancedBans.loadTemplates(templates, position + 1, callback);
			
		}) );
		
	}
	
	static set reference(reference) {
		this._reference = reference;
	}
	
	static get reference( ) {
		return this._reference;
	}
	
	static get configuration( ) {
		return this._configuration;
	}
	
	static set configuration(configuration) {
		this._configuration = configuration;
	}
	
	static get language( ) {
		return this._language;
	}
	
	static set language(language) {
		this._language = language;
	}
	
	static set Punishments(Punishments) {
		this._Punishments = Punishments;
	}
	
	static get Punishments( ) {
		return this._Punishments;
	}
	
	static set PunishmentHistory(PunishmentHistory) {
		this._PunishmentHistory = PunishmentHistory;
	}
	
	static get PunishmentHistory( ) {
		return this._PunishmentHistory;
	}
	
	static filter( ) {
		let pre_filter = this._PunishmentHistory;
		
		$.each(pre_filter, function(index) {
			
			/*
			 *	Support legacy version 1.2.5
			 *	Columns have different names
			 */
			
			if(AdvancedBans.configuration.get(["version"]) === "legacy") {
				pre_filter[index].punishmentType = "BAN";
				pre_filter[index].name = pre_filter[index].nick;
				pre_filter[index].operator = pre_filter[index].adminnick === "*Console*" ? "CONSOLE" : pre_filter[index].adminnick;
				pre_filter[index].start = parseInt(pre_filter[index].banfrom);
				
				/*
				 *	No longer need to reference banto from legacy version 1.2.5
				 */
				
				pre_filter[index].end = pre_filter[index].banto;
				
				
			/*
			 *	Support beta version 2.1.6
			 *	Date and time no longer stored from epoch
			 */
				
			} else if(AdvancedBans.configuration.get(["version"]) === "beta") {
				pre_filter[index].start = parseDate(pre_filter[index].start);
				
			/*
			 *	Support stable version 2.1.5
			 */
			
			} else if(AdvancedBans.configuration.get(["version"]) === "stable") {
				pre_filter[index].start = parseInt(pre_filter[index].start);
			}
			
			pre_filter[index].date = new Date(pre_filter[index].start);
			
			if(pre_filter[index].end && String(pre_filter[index].end).length > 2) {
			
				/*
				 *	Support legacy version 1.2.5
				 *	Columns have different names
				 */
				 
				if(AdvancedBans.configuration.get(["version"]) === "legacy") {
					pre_filter[index].end = parseInt(pre_filter[index].end);
				
				/*
				 *	Support beta version 2.1.6
				 *	Date and time no longer stored from epoch
				 */
					
				} else if(AdvancedBans.configuration.get(["version"]) === "beta") {
					pre_filter[index].end = parseDate(pre_filter[index].end);
					
				/*
				 *	Support stable version 2.1.5
				 */
				
				} else if(AdvancedBans.configuration.get(["version"]) === "stable") {
					pre_filter[index].end = parseInt(pre_filter[index].end);
				}
					
				pre_filter[index].expires = new Date(pre_filter[index].end);
			}
			
			/*
			 *	Support legacy version 1.2.5
			 *	Status saved as integer boolean value
			 */
			
			if(AdvancedBans.configuration.get(["version"]) === "legacy") {
				pre_filter[index].status = pre_filter[index].status === 1;
				
			/*
			 *	Support beta version 2.1.6
			 */
				
			} else if(AdvancedBans.configuration.get(["version"]) === "beta") {
				pre_filter[index].status = AdvancedBans.isActive(pre_filter[index].start, pre_filter[index].end);
				
			/*
			 *	Support stable version 2.1.5
			 */
			
			} else if(AdvancedBans.configuration.get(["version"]) === "stable") {
				pre_filter[index].status = AdvancedBans.isActive(pre_filter[index].start, pre_filter[index].end);
			}
			
			pre_filter[index].status = pre_filter[index].status ? AdvancedBans.language.get("active", "Active") : AdvancedBans.language.get("inactive", "Inactive");
			
		});
		
		let post_filter = { };
		
		$.each(pre_filter, function(index) {
			let allowed = {
				types: false,
				statuses: false
			};
			
			$.each(AdvancedBans.types, function(type) {
				if(pre_filter[index].punishmentType === type) allowed.types = true;
			});
			
			$.each(AdvancedBans.statuses, function(status) {
				if(pre_filter[index].status === status) allowed.statuses = true;
			});
			
			if( (allowed.types || Object.keys(AdvancedBans.types).length === 0) && (allowed.statuses || Object.keys(AdvancedBans.statuses).length === 0) ) post_filter[index] = pre_filter[index];
		});
		
		this.display(post_filter);
	}
	
	static display(post_filter) {
		let search = [ ];
	
		$.each(post_filter, function(index) {
			search.push(post_filter[index]);
		});
		
		if( $(".search input").val( ).length > 0 ) {
			let options = {
				threshold: 0.5,
				keys: [
					{
						name: "name", 
						weight: 0.7
					}, 
					{
						name: "operator", 
						weight: 0.5
					}, 
					{
						name: "reason", 
						weight: 0.3
					}
				]
			};
			
			let fuse = new Fuse(search, options);
			search = fuse.search( $(".search input").val( ) );
		}
		
		$(".punishment-wrapper").html( this.getTemplate("table").replace([this._language.get("type", "Type"), this._language.get("name", "Name"), this._language.get("reason", "Reason"), this._language.get("operator", "Operator"), this._language.get("date", "Date"), this._language.get("expires", "Expires"), this._language.get("status", "Status")]) );
		$("tbody, .pagination").empty( );
		
		let amount = search.length;
		
		search = search.slice( ( this._page - 1 ) * 25 , this._page * 25);
		
		let pages = Math.floor(amount / 25);
		
		if(amount % 25 > 0 || amount === 0) pages++;
		
		let minimum;
		let maximum;
		
		if(this._page < 5) minimum = 1, maximum = 9;
		else if(this._page > pages - 8) minimum = pages - 8, maximum = pages;
		else minimum = this._page - 4, maximum = this._page + 4;
		
		minimum = Math.max(1, minimum);
		maximum = Math.min(pages, maximum);
		
		if(this._page > 1) $(".pagination").append( this.getTemplate("page").replace(["inactive", 1, AdvancedBans.language.get("first", "First")]) ).append( this.getTemplate("page").replace(["inactive", this._page - 1, AdvancedBans.language.get("previous", "Previous")]) );

		for( ; minimum <= maximum; minimum++) $(".pagination").append( this.getTemplate("page").replace([this._page === minimum ? "active" : "inactive", minimum, minimum]) );
		
		if(this._page < pages) $(".pagination").append( this.getTemplate("page").replace(["inactive", this._page + 1, AdvancedBans.language.get("next", "Next")]) ).append( this.getTemplate("page").replace(["inactive", pages, AdvancedBans.language.get("last", "Last")]) );
		
		if(amount === 0) {
			$("tbody").html( this.getTemplate("error-no-punishments").replace([AdvancedBans.language.get("error_no_punishments", "No punishments could be listed on this page")]) );
		} else {
			$.each(search, function(index) {
				$("tbody").append( AdvancedBans.getTemplate("punishment").replace([search[index].id, AdvancedBans.language.get(search[index].punishmentType.toLowerCase( ), search[index].punishmentType), search[index].name, search[index].reason, search[index].operator, search[index].date.toLocaleString(AdvancedBans.language.discriminator, {month: "long", day: "numeric", year: "numeric"}) + " " + AdvancedBans.getTemplate("time").replace([search[index].date.toLocaleString(AdvancedBans.language.discriminator, {hour: "numeric", minute: "numeric"})]), search[index].expires ? search[index].expires.toLocaleString(AdvancedBans.language.discriminator, {month: "long", day: "numeric", year: "numeric"}) + " " + AdvancedBans.getTemplate("time").replace([search[index].expires.toLocaleString(AdvancedBans.language.discriminator, {hour: "numeric", minute: "numeric"})]) : AdvancedBans.language.get("error_not_evaluated", "N/A"), search[index].status]) );
			});
		
			this.loadImages( );
		}
		
		this._page = 1;
	}
	
	static isActive(date, expires) {
		let inactive = true;
		
		$.each(this._Punishments, function(index, value) {
			if(value.start === date && value.end === expires) inactive = false;
		});
		
		return ! inactive;
	}
	
	static setPlayers( ) {
		
		$.getJSON("https://mcapi.us/server/" + (AdvancedBans.configuration.get(["player_count", "query"]) ? "query" : "status") + "?ip=" + AdvancedBans.configuration.get(["player_count", "host"]) + "&port=" + AdvancedBans.configuration.get(["player_count", "port"]), function(data) {
			
			if(data.status === "success" && data.online) $(".players").text( data.players.now.toLocaleString( ) );
			else $(".players").text( AdvancedBans.language.get("error_not_evaluated", "N/A") );
			
		});
		
	}
	
	static get(callback) {
		
		$.getJSON(this._configuration.get(["mod_rewrite"]) === true ? "punishments" : "?request=punishments", function(data) {
			
			data.Punishments.sort(function(a, b) {
				return parseInt(a.id) > parseInt(b.id) ? -1 : parseInt(a.id) < parseInt(b.id) ? 1 : 0;
			});
				
			/*
			 *	Support legacy version 1.2.5
			 *	Table `PunishmentHistory` does not exist
			 */
			
			if(AdvancedBans.configuration.get(["version"]) === "legacy") {
				AdvancedBans.PunishmentHistory = data.Punishments;
				
			/*
			 *	Support beta version 2.1.6
			 */
				
			} else if(AdvancedBans.configuration.get(["version"]) === "beta") {
				data.PunishmentHistory.sort(function(a, b) {
					return parseInt(a.id) > parseInt(b.id) ? -1 : parseInt(a.id) < parseInt(b.id) ? 1 : 0;
				});
				
				AdvancedBans.Punishments = data.Punishments;
				AdvancedBans.PunishmentHistory = data.PunishmentHistory;
				
			/*
			 *	Support stable version 2.1.5
			 */
			
			} else if(AdvancedBans.configuration.get(["version"]) === "stable") {
				data.PunishmentHistory.sort(function(a, b) {
					return parseInt(a.id) > parseInt(b.id) ? -1 : parseInt(a.id) < parseInt(b.id) ? 1 : 0;
				});
				
				AdvancedBans.Punishments = data.Punishments;
				AdvancedBans.PunishmentHistory = data.PunishmentHistory;
			}
			
			callback( );
			
		});
		
	}
	
	static loadImages( ) {
		
		$("td img").each(function(index) {
			
			let profile = $(this); 
			
			$.getJSON("https://api.minetools.eu/uuid/" + profile.attr("data-name").replace(new RegExp("[.]", "g"), "_"), function(data) {
				
				if(data.id.length > 4) profile.attr("src", "https://crafatar.com/avatars/" + data.id + "?size=30");

			});
			
		});
		
	}
	
}