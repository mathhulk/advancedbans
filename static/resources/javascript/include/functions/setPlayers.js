function setPlayers( ) {
	$.getJSON("https://use.gameapis.net/mc/query/players/" + Configuration.get(["player_count", "server_ip"]), function(data) {
		if(data.status === true) $(".players").text(data.players.online.toLocaleString( ));
		else $(".players").text(Language.get("error_not_evaluated", "N/A"));
		
		setTimeout(setPlayers, 5000);
	});
}