class AdvancedBan {
	
	static initialize(callback) {
		Cookie.initialize("AdvancedBan");
		
		Configuration.initialize(function( ) {
			setManifest( );
			
			Language.initialize(Cookie.get("language") ? Cookie.get("language") : Configuration.get(["default", "language"]), function( ) {
				new Template("copied", ["copied"], function( ) {
					new Template("copy", ["copy"], function( ) {
						new Template("error-no-punishments", ["error_no_punishments"], function( ) {
							new Template("page", ["status", "page", "text"], function( ) {
								new Template("punishment", ["id", "type", "name", "reason", "operator", "date", "expires", "status"], function( ) {
									new Template("time", ["time"], function( ) {
										new Template("table", ["type", "name", "reason", "operator", "date", "expires", "status"], function( ) {

											if(Configuration.get(["player_count", "enabled"])) {
												new ClipboardJS(".clipboard");
												setPlayers( );
											}
											
											AdvancedBan.get(function( ) {
												$(".punishment-wrapper").html(__templates["table"].replace([Language.get("type", "Type"), Language.get("name", "Name"), Language.get("reason", "Reason"), Language.get("operator", "Operator"), Language.get("date", "Date"), Language.get("expires", "Expires"), Language.get("status", "Status")]));
												$("tbody, .pagination").empty( );
												AdvancedBan.set(1);
												
												callback( );
											});
											
										});
									});
								});
							});
						});
					});
				})
			});
		});
	}
	
	static get(callback) {
		$.getJSON(Configuration.get(["mod_rewrite"]) === true ? "punishments" : "?request=punishments", function(data) {
			__PunishmentHistory = data.PunishmentHistory, __Punishments = data.Punishments;
			
			callback( );
		});
	}
	
	static set(page) {
		let punishments = [ ];
		
		$.each(__PunishmentHistory, function(index, value) {
			if(AdvancedBan.isValid(value)) punishments.push(__PunishmentHistory[index]);
		});

		punishments.sort(function(a, b) {
			return parseInt(a.id) > parseInt(b.id) ? -1 : parseInt(a.id) < parseInt(b.id) ? 1 : 0;
		});
		
		let amount = punishments.length;
		
		if(page < 1) page = 1;
		
		if(punishments.length === 0) {
			$("tbody").html(__templates["error-no-punishments"].replace(Language.get("error_no_punishments", "No punishments could be listed on this page")));
		} else {
			$.each(punishments.splice((page - 1) * 25, 25), function(index, value) {
				let date = new Date(isNaN(value.start) ? parseDate(value.start) : parseInt(value.start));
				let expires;
				
				if(value.end && value.end !== "-1") expires = new Date(isNaN(value.end) ? parseDate(value.end) : parseInt(value.end));
				
				$("tbody").append(__templates["punishment"].replace([value.id, Language.get(value.punishmentType.toLowerCase( ), value.punishmentType), value.name, value.reason, value.operator, date.toLocaleString(Language.discriminator, {month: "long", day: "numeric", year: "numeric"}) + " " + __templates["time"].replace([date.toLocaleString(Language.discriminator, {hour: "numeric", minute: "numeric"})]), value.end && value.end !== "-1" ? expires.toLocaleString(Language.discriminator, {month: "long", day: "numeric", year: "numeric"}) + " " + __templates["time"].replace([expires.toLocaleString(Language.discriminator, {hour: "numeric", minute: "numeric"})]) : Language.get("error_not_evaluated", "N/A"), AdvancedBan.isActive(value.start, value.end) ? Language.get("active", "Active") : Language.get("inactive", "Inactive")]));
			});
		}
		
		let pages = Math.floor(punishments.length / 25);
		
		if(punishments.length % 25 !== 0 || punishments.length === 0) pages++;
		
		if(page > 1) {
			$(".pagination").append(__templates["page"].replace(["inactive", 1, Language.get("first", "First")])).append(__templates["page"].replace(["inactive", page - 1, Language.get("previous", "Previous")]));
		}

		let minimum, maximum;
		
		if(page < 5) minimum = 1, maximum = 9;
		else if(page > pages - 8) minimum = pages - 8, maximum = pages;
		else minimum = page - 4, maximum = page + 4;
		
		minimum = Math.max(1, minimum), maximum = Math.min(pages, maximum);
		
		for( ; minimum <= maximum; minimum++) {
			$(".pagination").append(__templates["page"].replace([page === minimum ? "active" : "inactive", minimum, minimum]));
		}
		
		if(page < pages) {
			$(".pagination").append(__templates["page"].replace(["inactive", page + 1, Language.get("next", "Next")])).append(__templates["page"].replace(["inactive", pages, Language.get("last", "Last")]));
		}
		
		$("td img").each(function(index) {
			let profile = $(this); 
			
			$.getJSON("https://api.minetools.eu/uuid/" + profile.attr("data-name").replace(new RegExp("[.]", "g"), "_"), function(data) {
				if(data.id.length > 4) profile.attr("src", "https://crafatar.com/avatars/" + data.id + "?size=30");
			});
		});
	}
	
	static isActive(date, expires) {
		let active = false;
		
		$.each(__Punishments, function(index, value) {
			if(value.start === date && value.end === expires) active = true;
		});
		
		return active;
	}
	
	static isValid(punishment) {
		if(__search.type.length > 0 && !__search.type.includes(punishment.punishmentType.toLowerCase( ))) {
			return false;
		}
		
		if(__search.status.length > 0 && !__search.status.includes(isActive(punishment.start, punishment.end) ? "active" : "inactive")) {
			return false;
		}
		
		if(__search.search.length > 0 && __search.input) {
			let valid = false;
			
			$.each(__search.search, function(index, value) {
				if(punishment[value].toLowerCase( ).includes(__search.input.toLowerCase( ))) valid = true;
			});
			
			if(!valid) return false;
		}
		
		if(__search.input && !punishment.name.toLowerCase( ).includes(__search.input.toLowerCase( )) && !punishment.reason.toLowerCase( ).includes(__search.input.toLowerCase( )) && !punishment.operator.toLowerCase( ).includes(__search.input.toLowerCase( ))) {
			return false;
		}
		
		return true;
	}
	
}