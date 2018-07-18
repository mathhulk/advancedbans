/*
 *	FUNCTIONS
 */
function updatePlayers(server, replace, error) {
	$.getJSON("https://use.gameapis.net/mc/query/players/" + server, function(data) {
		if(data.status == true) {
			$(replace).text(data.players.online.toLocaleString( ));
		} else {
			$(replace).text(error);
		}
		setTimeout(updatePlayers, 5000, server, replace, error);
	});
}

/*
 *	EVENTS
 */
$(document).on("mouseenter", ".clipboard", function() {
	if(!$(this).find("a .copy").length) {
		$(this).find("a").append(" <span class=\"badge copy\"><i class=\"fa fa-clipboard\"></i> Copy</span>");
	}
});
$(document).on("mouseleave", ".clipboard", function() {
	$(this).find("a .copy").remove( );
});
$(document).on("click", ".clipboard", function() {
	$(this).find("a .copy").html("<i class=\"fa fa-clipboard\"></i> Copied");
});

/*
 *	LOAD
 */
$(document).ready(function() {
	new Clipboard(".clipboard");
});