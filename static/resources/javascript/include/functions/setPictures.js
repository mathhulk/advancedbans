async function setPictures( ) {
	$("td img").each(function(index) {
		let profile = $(this); 
		
		$.getJSON("https://api.minetools.eu/uuid/" + profile.attr("data-name").replace(new RegExp("[.]", "g"), "_"), function(data) {
			if(data.id.length > 4) {
				profile.attr("src", "https://crafatar.com/avatars/" + data.id + "?size=30");
			}
		});
	});
}