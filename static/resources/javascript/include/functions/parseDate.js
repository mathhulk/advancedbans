function parseDate(date) {
	return date.split(".")[0].replace(new RegExp("-", "g"), "/");
}