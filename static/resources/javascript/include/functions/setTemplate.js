function setTemplate(templates, position, callback) {
	
	AdvancedBan.setTemplate(templates[position][0], new Template(templates[position][0], templates[position][1], function( ) {
		
		if(position === templates.length - 1) {
			if(AdvancedBan.configuration.get(["player_count", "enabled"])) {
				new ClipboardJS(".clipboard");
				setPlayers( );
			}
			
			AdvancedBan.get(function( ) {
				AdvancedBan.sort( );
				AdvancedBan.load(1);
			});
			
			callback( );
		} else {
			setTemplate(templates, position + 1, callback);
		}
		
	}));
	
}