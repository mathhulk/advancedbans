function setManifest( ) {
	$("#manifest").attr("href", URL.createObjectURL(new Blob([JSON.stringify({
		name: Configuration.get(["messages", "title"]),
		short_name: Configuration.get(["messages", "title"]),
		start_url: ".",
		display: "minimal-ui",
		background_color: "#fff",
		description: Configuration.get(["messages", "description"]),
		lang: "en-US",
		icons: [
			{
				src: "static/resources/images/icons/apple-icon-57x57.png",
				sizes: "57x57"
			},
			{
				src: "static/resources/images/icons/apple-icon-60x60.png",
				sizes: "60x60"
			},
			{
				src: "static/resources/images/icons/apple-icon-72x72.png",
				sizes: "72x72"
			},
			{
				src: "static/resources/images/icons/apple-icon-76x76.png",
				sizes: "76x76"
			},
			{
				src: "static/resources/images/icons/apple-icon-114x114.png",
				sizes: "114x114"
			},
			{
				src: "static/resources/images/icons/apple-icon-120x120.png",
				sizes: "120x120"
			},
			{
				src: "static/resources/images/icons/apple-icon-144x144.png",
				sizes: "144x144"
			},
			{
				src: "static/resources/images/icons/apple-icon-152x152.png",
				sizes: "152x152"
			},
			{
				src: "static/resources/images/icons/apple-icon-180x180.png",
				sizes: "180x180"
			},
			{
				src: "static/resources/images/icons/android-icon-192x192.png",
				sizes: "192x192"
			},
			{
				src: "static/resources/images/icons/favicon-32x32.png",
				sizes: "32x32"
			},
			{
				src: "static/resources/images/icons/favicon-96x96.png",
				sizes: "96x96"
			},
			{
				src: "static/resources/images/icons/favicon-16x16.png",
				sizes: "16x16"
			}
		]
	})]), {type: "application/json"}));
}