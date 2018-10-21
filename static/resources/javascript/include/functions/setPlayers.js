function setPlayers( ) {
	$.getJSON("https://use.gameapis.net/mc/query/players/" + AdvancedBan.configuration.get(["player_count", "server_ip"]), function(data) {
		if(data.status === true) $(".players").text(data.players.online.toLocaleString( ));
		else $(".players").text(AdvancedBan.language.get("error_not_evaluated", "N/A"));
		
		setTimeout(setPlayers, 5000);
	});
}