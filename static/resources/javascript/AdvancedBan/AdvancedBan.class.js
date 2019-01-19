class AdvancedBan {
	
	static initialize(callback) {
		this._templates = { };
		this._search = { };
		
		this._reference = [[ "copied", ["copied"]], ["copy", ["copy"]], ["error-no-punishments", ["error_no_punishments"]], ["page", ["status", "page", "text"]], ["punishment", ["id", "type", "name", "reason", "operator", "date", "expires", "status"]], ["time", ["time"]], ["table", ["type", "name", "reason", "operator", "date", "expires", "status"]]];
		
		Cookie.initialize("AdvancedBan");
		
		this._configuration = new Configuration("static/configuration.json", function( ) {
			AdvancedBan.language = new Language(Cookie.get("language") ? Cookie.get("language") : AdvancedBan.configuration.get(["default", "language"]), function( ) {
				AdvancedBan.loadTemplates(AdvancedBan.reference, 0, function( ) {
					if(AdvancedBan.configuration.get(["player_count", "enabled"])) {
						new ClipboardJS(".clipboard");
						
						AdvancedBan.query( );
						setInterval(AdvancedBan.query, 1000 * 10);
					}
					
					AdvancedBan.get(function( ) {
						AdvancedBan.sort( );
						AdvancedBan.load(1);
					});
					
					callback( );
				});
			});
		});
	}
	
	static get cache( ) {
		return this._cache;
	}
	
	static set cache(cache) {
		this._cache = cache;
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
	
	static set templates(templates) {
		this._templates = templates;
	}
	
	static get templates( ) {
		return this._templates;
	}
	
	static set search(search) {
		this._search = search;
	}
	
	static get search( ) {
		return this._search;
	}
	
	static set reference(reference) {
		this._reference = reference;
	}
	
	static get reference( ) {
		return this._reference;
	}
	
	static setTemplate(name, template) {
		this._templates[name] = template;
	}
	
	static getTemplate(template) {
		return this._templates[template];
	}
	
	static loadTemplates(templates, position, callback) {
		AdvancedBan.setTemplate(templates[position][0], new Template(templates[position][0], templates[position][1], function( ) {
			if(position === templates.length - 1) {
				callback( );
			} else {
				AdvancedBan.loadTemplates(templates, position + 1, callback);
			}
		}));
	}
	
	static sort( ) {
		this._cache = [ ];
		
		$.each(this._PunishmentHistory, function(index, value) {
			if(AdvancedBan.filter(value)) {
				let cache = AdvancedBan.cache;
				cache.push(AdvancedBan.PunishmentHistory[index]);
				AdvancedBan.cache = cache;
			}
		});
		
		this._cache.sort(function(a, b) {
			return parseInt(a.id) > parseInt(b.id) ? -1 : parseInt(a.id) < parseInt(b.id) ? 1 : 0;
		});
	}
	
	static query( ) {
		$.getJSON("https://mcapi.us/server/" + (AdvancedBan.configuration.get(["player_count", "query"]) ? "query" : "status") + "?ip=" + AdvancedBan.configuration.get(["player_count", "host"]) + "&port=" + AdvancedBan.configuration.get(["player_count", "port"]), function(data) {
			if(data.status === "success" && data.online) {
				$(".players").text(data.players.now.toLocaleString( ));
			} else {
				$(".players").text(AdvancedBan.language.get("error_not_evaluated", "N/A"));
			}
		});
	}
	
	static profile( ) {
		$("td img").each(function(index) {
			let profile = $(this); 
			
			$.getJSON("https://api.minetools.eu/uuid/" + profile.attr("data-name").replace(new RegExp("[.]", "g"), "_"), function(data) {
				if(data.id.length > 4) {
					profile.attr("src", "https://crafatar.com/avatars/" + data.id + "?size=30");
				}
			});
		});
	}
	
	static load(page) {
		let list = this._cache.slice((page - 1) * 25, page * 25);
		let amount = this._cache.length;
		
		let pages = Math.floor(amount / 25);
		
		if(amount % 25 > 0 || amount === 0) {
			pages++;
		}
		
		let minimum;
		let maximum;
		
		if(page < 5) {
			minimum = 1, maximum = 9;
		} else if(page > pages - 8) {
			minimum = pages - 8, maximum = pages;
		} else {
			minimum = page - 4, maximum = page + 4;
		}
		
		minimum = Math.max(1, minimum);
		maximum = Math.min(pages, maximum);
		
		$(".punishment-wrapper").html(this.getTemplate("table").replace([this._language.get("type", "Type"), this._language.get("name", "Name"), this._language.get("reason", "Reason"), this._language.get("operator", "Operator"), this._language.get("date", "Date"), this._language.get("expires", "Expires"), this._language.get("status", "Status")]));
		$("tbody, .pagination").empty( );
		
		if(list.length === 0) {
			$("tbody").html(this.getTemplate("error-no-punishments").replace([AdvancedBan.language.get("error_no_punishments", "No punishments could be listed on this page")]));
		} else {
			$.each(list, function(index, value) {
				
				/*
				 *	Support legacy version 1.2.5
				 *	Columns have different names
				 */
				
				if(AdvancedBan.configuration.get(["version"]) === "legacy") {
					value.punishmentType = "BAN";
					value.name = value.nick;
					value.operator = value.adminnick === "*Console*" ? "CONSOLE" : value.adminnick;
					value.start = parseInt(value.banfrom);
					
					/*
					 *	No longer need to reference banto from legacy version 1.2.5
					 */
					
					value.end = value.banto;
					
					
				/*
				 *	Support beta version 2.1.6
				 *	Date and time no longer stored from epoch
				 */
					
				} else if(AdvancedBan.configuration.get(["version"]) === "beta") {
					value.start = parseDate(value.start);
					
				/*
				 *	Support stable version 2.1.5
				 */
				
				} else if(AdvancedBan.configuration.get(["version"]) === "stable") {
					value.start = parseInt(value.start);
				}
				
				let date = new Date(value.start);
				
				let expires;
				
				if(value.end && String(value.end).length > 2) {
				
					/*
					 *	Support legacy version 1.2.5
					 *	Columns have different names
					 */
					 
					if(AdvancedBan.configuration.get(["version"]) === "legacy") {
						value.end = parseInt(value.end);
					
					/*
					 *	Support beta version 2.1.6
					 *	Date and time no longer stored from epoch
					 */
						
					} else if(AdvancedBan.configuration.get(["version"]) === "beta") {
						value.end = parseDate(value.end);
						
					/*
					 *	Support stable version 2.1.5
					 */
					
					} else if(AdvancedBan.configuration.get(["version"]) === "stable") {
						value.end = parseInt(value.end);
					}
						
					expires = new Date(value.end);
				}
				
				let status;
				
				/*
				 *	Support legacy version 1.2.5
				 *	Status saved as integer boolean value
				 */
				
				if(AdvancedBan.configuration.get(["version"]) === "legacy") {
					status = value.status === 1;
					
				/*
				 *	Support beta version 2.1.6
				 */
					
				} else if(AdvancedBan.configuration.get(["version"]) === "beta") {
					status = AdvancedBan.active(value.start, value.end);
					
				/*
				 *	Support stable version 2.1.5
				 */
				
				} else if(AdvancedBan.configuration.get(["version"]) === "stable") {
					status = AdvancedBan.active(value.start, value.end);
				}
				
				$("tbody").append(AdvancedBan.getTemplate("punishment").replace([value.id, AdvancedBan.language.get(value.punishmentType.toLowerCase( ), value.punishmentType), value.name, value.reason, value.operator, date.toLocaleString(AdvancedBan.language.discriminator, {month: "long", day: "numeric", year: "numeric"}) + " " + AdvancedBan.getTemplate("time").replace([date.toLocaleString(AdvancedBan.language.discriminator, {hour: "numeric", minute: "numeric"})]), expires ? expires.toLocaleString(AdvancedBan.language.discriminator, {month: "long", day: "numeric", year: "numeric"}) + " " + AdvancedBan.getTemplate("time").replace([expires.toLocaleString(AdvancedBan.language.discriminator, {hour: "numeric", minute: "numeric"})]) : AdvancedBan.language.get("error_not_evaluated", "N/A"), status ? AdvancedBan.language.get("active", "Active") : AdvancedBan.language.get("inactive", "Inactive")]));
			});
		}
		
		if(page > 1) {
			$(".pagination").append(this.getTemplate("page").replace(["inactive", 1, AdvancedBan.language.get("first", "First")])).append(this.getTemplate("page").replace(["inactive", page - 1, AdvancedBan.language.get("previous", "Previous")]));
		}

		for( ; minimum <= maximum; minimum++) {
			$(".pagination").append(this.getTemplate("page").replace([page === minimum ? "active" : "inactive", minimum, minimum]));
		}
		
		if(page < pages) {
			$(".pagination").append(this.getTemplate("page").replace(["inactive", page + 1, AdvancedBan.language.get("next", "Next")])).append(this.getTemplate("page").replace(["inactive", pages, AdvancedBan.language.get("last", "Last")]));
		}
		
		this.profile( );
	}
	
	static get(callback) {
		$.getJSON(this._configuration.get(["mod_rewrite"]) === true ? "punishments" : "?request=punishments", function(data) {
				
			/*
			 *	Support legacy version 1.2.5
			 *	Table `PunishmentHistory` does not exist
			 */
			
			if(AdvancedBan.configuration.get(["version"]) === "legacy") {
				AdvancedBan.PunishmentHistory = data.Punishments;
				
			/*
			 *	Support beta version 2.1.6
			 */
				
			} else if(AdvancedBan.configuration.get(["version"]) === "beta") {
				AdvancedBan.Punishments = data.Punishments;
				AdvancedBan.PunishmentHistory = data.PunishmentHistory;
				
			/*
			 *	Support stable version 2.1.5
			 */
			
			} else if(AdvancedBan.configuration.get(["version"]) === "stable") {
				AdvancedBan.Punishments = data.Punishments;
				AdvancedBan.PunishmentHistory = data.PunishmentHistory;
			}
			
			callback( );
		});
	}
	
	static active(date, expires) {
		$.each(this._Punishments, function(index, value) {
			if(value.start === date && value.end === expires) {
				return true;
			}
		});
		
		return false;
	}
	
	static filter(punishment) {
		if(this._search.punishmentType && this._search.punishmentType.length > 0 && this._search.punishmentType.includes(punishment.punishmentType.toLowerCase( )) === false) {
			return false;
		}
		
		if(this._search.punishmentStatus && this._search.punishmentStatus.length > 0) {
			let status;
				
			/*
			 *	Support legacy version 1.2.5
			 *	Status saved as integer boolean value
			 */
			
			if(this._configuration.get(["version"]) === "legacy") {
				status = punishment.status === 1;
				
			/*
			 *	Support beta version 2.1.6
			 */
				
			} else if(this._configuration.get(["version"]) === "beta") {
				status = active(punishment.start, punishment.end);
				
			/*
			 *	Support stable version 2.1.5
			 */
			
			} else if(this._configuration.get(["version"]) === "stable") {
				status = active(punishment.start, punishment.end);
			}
			
			if(this._search.punishmentStatus.includes(status ? "active" : "inactive") === false) {
				return false;
			}
		}
		
		if(this._search.input) {
			let valid = false;
			let inputType = ["name", "reason", "operator"];
			
			if(this._search.inputType && this._search.inputType.length > 0) {
				inputType = this._search.inputType;
			}
			
			$.each(inputType, function(index, value) {
				if(punishment[value].toLowerCase( ).includes(AdvancedBan.search.input.toLowerCase( ))) {
					valid = true;
				}
			});
			
			if(valid === false) {
				return false;
			}
		}
		
		return true;
	}
	
}