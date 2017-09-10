/*
 *	FUNCTIONS
 */
function updatePlayers(server, replace, error) {
	$.getJSON("https://mcapi.ca/query/" + server + "/players", function(data) {
		if(data.status == true) {
			$(replace).text(data.players.online.toLocaleString());
		} else {
			$(replace).text(error);
		}
		setTimeout(updatePlayers, 5000, server, replace, error);
	});
}