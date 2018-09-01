// VARIABLES
var __public, __log, __punishment, __language, __templates = { }, __search = {type: [ ], status: [ ], search: [ ]};
var playersUpdate, imagesSet;

// FUNCTIONS
function updatePlayers( ) {
	$.getJSON("https://use.gameapis.net/mc/query/players/" + __public.player_count.server_ip, function(data) {
		if(data.status === true) $(".players").text(data.players.online.toLocaleString( ));
		else $(".players").text(getLocale("error_not_evaluated", "N/A"));
		
		clearTimeout(playersUpdate);
		playersUpdate = setTimeout(updatePlayers, 5000);
	});
}

function getLocale(index, standard) {
	return __language[index] ? __language[index] : standard; 
}

function getCookie(name) {
    let cookies = decodeURIComponent(document.cookie).split(";");
    for(let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i];
        while(cookie.charAt(0) === " ") cookie = cookie.substring(1);
        if(cookie.indexOf(name + "=") === 0) return cookie.substring((name + "=").length, cookie.length);
    }
    return false;
}

function replace(template, placeholder) {
	$.each(placeholder, function(index, value) {
		template = template.replace(new RegExp("{{ " + index + " }}", "g"), value);
	});
	return template;
}

function isActive(start, end) {
	let active = false;
	$.each(__punishment, function(index, value) {
		if(value.start === start && value.end === end) active = true;
	});
	return active;
}

function clearContent( ) {
	$("tbody, .pagination").empty( );
}

function validate(punishment) {
	if(__search.type.length > 0 && !__search.type.includes(punishment.punishmentType.toLowerCase( ))) return false;
	if(__search.status.length > 0 && !__search.status.includes(isActive(punishment.start, punishment.end) ? "active" : "inactive")) return false;
	if(__search.search.length > 0 && __search.input) {
		let valid = false;
		$.each(__search.search, function(index, value) {
			if(punishment[value].toLowerCase( ).includes(__search.input.toLowerCase( ))) valid = true;
		});
		if(!valid) return false;
	}
	if(__search.input && !punishment.name.toLowerCase( ).includes(__search.input.toLowerCase( )) && !punishment.reason.toLowerCase( ).includes(__search.input.toLowerCase( )) && !punishment.operator.toLowerCase( ).includes(__search.input.toLowerCase( ))) return false;
	return true;
}

function setPunishments(page) {
	let punishments = [ ];
	
	$.each(__log, function(index, value) {
		if(validate(value)) punishments.push(__log[index]);
	});

	punishments.sort(function(a, b) {
		return parseInt(a.id) > parseInt(b.id) ? -1 : parseInt(a.id) < parseInt(b.id) ? 1 : 0;
	});
	
	let amount = punishments.length;
	
	if(page < 1) page = 1;
	
	if(punishments.length === 0) {
		$("tbody").html(replace(__templates["no-punishments"], {error_no_punishments: getLocale("error_no_punishments", "No punishments could be listed on this page")}));
	} else {
		$.each(punishments.splice((page - 1) * 25, 25), function(index, value) {
			let date = new Date(isNaN(value.start) ? value.start : parseInt(value.start));
			if(value.end && value.end !== -1) expires = new Date(isNaN(value.end) ? value.end : parseInt(value.end));
			
			$("tbody").append(replace(__templates["punishment"], {id: value.id, name: value.name, reason: value.reason, operator: value.operator, date: date.toLocaleString(getCookie("advancedban-panel_language") ? getCookie("advancedban-panel_language") : __public.default.language, {month: "long", day: "numeric", year: "numeric"}) + " <span class=\"badge\">" + date.toLocaleString(getCookie("advancedban-panel_language") ? getCookie("advancedban-panel_language") : __public.default.language, {hour: "numeric", minute: "numeric"}) + "</span>", expires: value.end ? expires.toLocaleString(getCookie("advancedban-panel_language") ? getCookie("advancedban-panel_language") : __public.default.language, {month: "long", day: "numeric", year: "numeric"}) + " <span class=\"badge\">" + expires.toLocaleString(getCookie("advancedban-panel_language") ? getCookie("advancedban-panel_language") : __public.default.language, {hour: "numeric", minute: "numeric"}) + "</span>" : getLocale("error_not_evaluated", "N/A"), type: getLocale(value.punishmentType.toLowerCase( ), value.punishmentType), status: isActive(value.start, value.end) ? getLocale("active", "Active") : getLocale("inactive", "Inactive")}));
		});
	}
	
	setPagination(page, amount);
	clearTimeout(imagesSet);
	imagesSet = setTimeout(setImages, 50);
}

function setImages( ) {
	$("td img").each(function(index) {
		let profile = $(this); 
		
		$.getJSON("https://api.minetools.eu/uuid/" + profile.attr("data-name").replace(new RegExp("[.]", "g"), "_"), function(data) {
			if(data.id.length > 4) profile.attr("src", "https://crafatar.com/avatars/" + data.id + "?size=30");
		});
	});
}

function setPagination(page, punishments) {
	let pages = Math.floor(punishments / 25);
	if(punishments % 25 !== 0 || punishments === 0) pages++;
	
	if(page > 1) $(".pagination").append(replace(__templates["page"], {page: 1, text: "<i class=\"fa fa-angle-double-left\"></i> " + getLocale("first", "First")})).append(replace(__templates["page"], {page: page - 1, text: "<i class=\"fa fa-angle-left\"></i> " + getLocale("previous", "Previous")}));

	let minimum, maximum;
	if(page < 5) minimum = 1, maximum = 9;
	else if(page > pages - 8) minimum = pages - 8, maximum = pages;
	else minimum = page - 4, maximum = page + 4;
	
	minimum = Math.max(1, minimum), maximum = Math.min(pages, maximum);
	
	for(; minimum <= maximum; minimum++) $(".pagination").append(replace(__templates["page"], {page: minimum, text: minimum, status: page === minimum ? "active" : "inactive"}));
	
	if(page < pages) $(".pagination").append(replace(__templates["page"], {page: page + 1, text: getLocale("next", "Next") + " <i class=\"fa fa-angle-right\"></i>"})).append(replace(__templates["page"], {page: pages, text: getLocale("last", "Last") + " <i class=\"fa fa-angle-double-right\"></i>"}));
}

// EVENTS
$(document).ready(function( ) {
	$.getJSON("include/public.json", function(data) {
		__public = data;
		
		$("#manifest").attr("href", URL.createObjectURL(new Blob([JSON.stringify({
			name: __public.messages.title,
			short_name: __public.messages.title,
			start_url: ".",
			display: "minimal-ui",
			background_color: "#fff",
			description: __public.messages.description,
			lang: "en-US",
			icons: [
				{
					src: "/assets/img/icons/apple-icon-57x57.png",
					sizes: "57x57"
				},
				{
					src: "/assets/img/icons/apple-icon-60x60.png",
					sizes: "60x60"
				},
				{
					src: "/assets/img/icons/apple-icon-72x72.png",
					sizes: "72x72"
				},
				{
					src: "/assets/img/icons/apple-icon-76x76.png",
					sizes: "76x76"
				},
				{
					src: "/assets/img/icons/apple-icon-114x114.png",
					sizes: "114x114"
				},
				{
					src: "/assets/img/icons/apple-icon-120x120.png",
					sizes: "120x120"
				},
				{
					src: "/assets/img/icons/apple-icon-144x144.png",
					sizes: "144x144"
				},
				{
					src: "/assets/img/icons/apple-icon-152x152.png",
					sizes: "152x152"
				},
				{
					src: "/assets/img/icons/apple-icon-180x180.png",
					sizes: "180x180"
				},
				{
					src: "/assets/img/icons/android-icon-192x192.png",
					sizes: "192x192"
				},
				{
					src: "/assets/img/icons/favicon-32x32.png",
					sizes: "32x32"
				},
				{
					src: "/assets/img/icons/favicon-96x96.png",
					sizes: "96x96"
				},
				{
					src: "/assets/img/icons/favicon-16x16.png",
					sizes: "16x16"
				}
			]
		})]), {type: "application/json"}));
		
		$.getJSON("include/languages/" + (getCookie("advancedban-panel_language") ? getCookie("advancedban-panel_language") : __public.default.language) + ".json", function(data) {
			__language = data.terms;
			
			if(__public.player_count.enabled === true) {
				new Clipboard(".clipboard");
				updatePlayers( );
			}
			
			$.getJSON(__public.mod_rewrite === true ? "punishments/" : "?path=punishments/", function(data) {
				__log = data.log, __punishment = data.punishment;
				
				if(window.location.pathname.split("/") === "statistics") {
					
					// statistics
					
				} else {
					$.get("templates/no-punishments.txt", function(data) {
						__templates["no-punishments"] = data;
						
						$.get("templates/punishment.txt", function(data) {
							__templates["punishment"] = data;
							
							$.get("templates/page.txt", function(data) {
								__templates["page"] = data;
								
								clearContent( );
								setPunishments(1);
							});
						});
					});
				}
			});
		});
	});
	
	$(document).on("mouseenter", ".clipboard", function( ) {
		if(!$(this).find("a .copy").length) $(this).find("a").append(" <span class=\"badge copy\"><i class=\"fa fa-clipboard\"></i> " + getLocale("copy", "Copy") + "</span>");
	});

	$(document).on("mouseleave", ".clipboard", function( ) {
		$(this).find("a .copy").remove( );
	});
	
	$(document).on("click", ".clipboard", function( ) {
		$(this).find("a .copy").html("<i class=\"fa fa-clipboard\"></i> " + getLocale("copied", "Copied"));
	});
	
	$(document).on("click", ".pagination li a", function( ) {
		$("html, body").animate({scrollTop: 0}, "slow");
		
		clearContent( );
		setPunishments(parseInt($(this).attr("data-page")));
	});
	
	$(document).on("click", ".search .dropdown-menu li a", function( ) {
		if($(this).closest("li").hasClass("active")) {
			$(this).closest("li").removeClass("active");
			__search[$(this).closest("ul").attr("aria-labelledby")].splice(__search[$(this).closest("ul").attr("aria-labelledby")].indexOf($(this).attr("data-search")), 1);
		} else {
			$(this).closest("li").addClass("active");
			__search[$(this).closest("ul").attr("aria-labelledby")].push($(this).attr("data-search"));
		}
	
		clearContent( );
		setPunishments(1);
	});
	
	$(document).on("input", ".search input", function( ) {
		__search.input = $(this).val( );
		
		clearContent( );
		setPunishments(1);
	});
	
	$(document).on("click", ".search .dropdown-menu", function(event) {
		event.stopPropagation( );
	});
});