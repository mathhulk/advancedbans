var __PunishmentHistory, __Punishments;
var __templates = { };
var __search = {type: [ ], status: [ ], search: [ ]};

$(document).ready(function( ) {
	AdvancedBan.initialize(function( ) {
		$(document).on("mouseenter", ".clipboard", function( ) {
			if(!$(this).find("a .copy").length) {
				$(this).find("a").append(__templates["copy"].replace([Language.get("copy", "Copy")]));
			}
		});

		$(document).on("mouseleave", ".clipboard", function( ) {
			$(this).find("a .copy").remove( );
		});
		
		$(document).on("click", ".clipboard", function( ) {
			$(this).find("a .copy").html(__templates["copied"].replace([Language.get("copied", "Copied")]));
		});
		
		$(document).on("click", ".pagination li a", function( ) {
			$("html, body").animate({scrollTop: 0}, "slow");
			
			$("tbody, .pagination").empty( );
			AdvancedBan.set(parseInt($(this).attr("data-page")));
		});
		
		$(document).on("click", ".search .dropdown-menu .dropdown-item", function( ) {
			if($(this).hasClass("active")) {
				$(this).removeClass("active");
				__search[$(this).closest("div").attr("aria-labelledby")].splice(__search[$(this).closest("div").attr("aria-labelledby")].indexOf($(this).attr("data-search")), 1);
			} else {
				$(this).addClass("active");
				__search[$(this).closest("div").attr("aria-labelledby")].push($(this).attr("data-search"));
			}
		
			$("tbody, .pagination").empty( );
			AdvancedBan.set(1);
		});
		
		$(document).on("input", ".search input", function( ) {
			__search.input = $(this).val( );
			
			$("tbody, .pagination").empty( );
			AdvancedBan.set(1);
		});
		
		$(document).on("click", ".search .dropdown-menu", function(event) {
			event.stopPropagation( );
		});
	});
});