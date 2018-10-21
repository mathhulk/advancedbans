$(document).ready(function( ) {
	
	AdvancedBan.initialize(function( ) {
		
		$(document).on("mouseenter", ".clipboard", function( ) {
			if($(this).find("a .copy").length === 0) $(this).find("a").append(AdvancedBan.getTemplate("copy").replace([AdvancedBan.language.get("copy", "Copy")]));
		});

		$(document).on("mouseleave", ".clipboard", function( ) {
			$(this).find("a .copy").remove( );
		});
		
		$(document).on("click", ".clipboard", function( ) {
			$(this).find("a .copy").html(AdvancedBan.getTemplate("copied").replace([AdvancedBan.language.get("copied", "Copied")]));
		});
		
		$(document).on("click", ".pagination li a", function( ) {
			$("html, body").animate({scrollTop: 0}, "slow");
			
			AdvancedBan.load(parseInt($(this).attr("data-page")));
		});
		
		$(document).on("click", ".search .dropdown-menu .dropdown-item", function( ) {
			if($(this).hasClass("active")) {
				$(this).removeClass("active");
				
				let search = AdvancedBan.search;
				search[$(this).closest("div").attr("aria-labelledby")].splice(search[$(this).closest("div").attr("aria-labelledby")].indexOf($(this).attr("data-search")), 1);
				AdvancedBan.search = search;
			} else {
				$(this).addClass("active");
				
				let search = AdvancedBan.search;
				search[$(this).closest("div").attr("aria-labelledby")].push($(this).attr("data-search"));
				AdvancedBan.search = search;
			}
		
			AdvancedBan.load(1);
		});
		
		$(document).on("input", ".search input", function( ) {
			let search = AdvancedBan.search;
			search.input = $(this).val( );
			AdvancedBan.search = search;
			
			AdvancedBan.load(1);
		});
		
		$(document).on("click", ".search .dropdown-menu", function(event) {
			event.stopPropagation( );
		});
		
	});
	
});