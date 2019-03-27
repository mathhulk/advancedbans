$(document).ready(function( ) {
	
	AdvancedBans.initialize(function( ) {
		
		AdvancedBans.filter( );
		
		$(document).on("mouseenter", ".clipboard", function( ) {
			if($(this).find("a .copy").length === 0) $(this).find("a").append( AdvancedBans.getTemplate("copy").replace([AdvancedBans.language.get("copy", "Copy")]) );
		});

		$(document).on("mouseleave", ".clipboard", function( ) {
			$(this).find("a .copy").remove( );
		});
		
		$(document).on("click", ".clipboard", function( ) {
			$(this).find("a .copy").html( AdvancedBans.getTemplate("copied").replace([AdvancedBans.language.get("copied", "Copied")]) );
		});
		
		$(document).on("click", ".pagination li a", function( ) {
			AdvancedBans.page = parseInt( $(this).attr("data-page") );
			
			AdvancedBans.filter( );
		});
		
		$(".search-type .dropdown-menu .dropdown-item").click(function( ) {
			if( $(this).hasClass("active") ) AdvancedBans.removeType( $(this).attr("data-search") );
			else AdvancedBans.addType( $(this).attr("data-search") );
			
			$(this).toggleClass("active");
		});
		
		$(".search-status .dropdown-menu .dropdown-item").click(function( ) {
			if( $(this).hasClass("active") ) AdvancedBans.removeStatus( $(this).attr("data-search") );
			else AdvancedBans.addStatus( $(this).attr("data-search") );
			
			$(this).toggleClass("active");
		});
		
		$("#filter").click(function( ) {
			AdvancedBans.filter( );
		});
		
		$(document).on("click", ".search .dropdown-menu", function(event) {
			event.stopPropagation( );
		});
		
	});
	
});