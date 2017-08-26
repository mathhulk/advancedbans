# ab-web-addon
A simple, but sleek, web addon for AdvancedBan.
- You can find the example [here](https://mathhulk.info/ab-web-addon).

## Main Features
- Host it on your own web server
- Switch themes using Bootswatch
- Translate using language files
- List punishments by type
- List punishments by user
- View the state of a punishment
- Graphs to represent statistics

## Requirements
- PHP 5.6+ (7.0+ recommended)
- MySQLi PHP extension

## Setup
After you have uploaded all files to the wanted location on your web server, open `database.php` with your favorite text editor and replace the dummy MySQL connection details with those of your own MySQL database.
```php
/*
 *	MYSQL CONNECTION (host, user, password, database)
 */
$con = mysqli_connect("host", "user", "password", "database");
```
To configure the features provided, open `config.json` with your favorite text editor and change the available options to your liking.
```json
{	
	"theme": "yeti",
	"table": "Punishments",
	"history": "PunishmentHistory",
	"language": "en_US",
	"skulls": true,
	"compact": false,
	"ip-bans": true
}
```

## Languages
Translating ab-web-addon is simple. Simply create a new JSON file in `/language/` and copy the default `en_US.json` (English) language template to that file. Then, replace the terms with the correct translation.
```json
{
	"language": "English",
	"terms": {
		"title": "AdvancedBan Web Addon",
		"description": "A simple, but sleek, web addon for AdvancedBan.",
		"punishments": "Punishments",
		"credits": "Credits",
		"search": "Search for...",
		"submit": "Submit",
		"permanently_banned": "Permanently Banned",
		"until": "Banned until ",
		"not_banned": "Not Banned",
		"inactive": "Inactive",
		"active": "Active",
		"graphs": "Graphs",
		"graph_title": "7 Days of Punishments",
		"first": "First",
		"previous": "Previous",
		"next": "Next",
		"last": "Last",
		"username": "Username",
		"reason": "Reason",
		"operator": "Operator",
		"date": "Date",
		"end": "End",
		"type": "Type",
		"status": "Status",
		"ban": "Ban",
		"temp_ban": "Temp. Ban",
		"ip_ban": "IP Ban",
		"mute": "Mute",
		"temp_mute": "Temp. Mute",
		"warning": "Warning",
		"temp_warning": "Temp. Warning",
		"kick": "Kick",
		"all": "All",
		"bans": "Bans",
		"temp_bans": "Temp. Bans",
		"ip_bans": "IP Bans",
		"mutes": "Mutes",
		"temp_mutes": "Temp. Mutes",
		"warnings": "Warnings",
		"temp_warnings": "Temp. Warnings",
		"kicks": "Kicks",
		"error_no_punishments": "No punishments could be listed on this page.",
		"error_not_evaluated": "N/A"
	}
}
```
I am always looking for new translations. If you are fluent in another language, consider translating ab-web-addon and opening a pull request.

## Favicon
If you wish to change the favicon, replace the `icon.png` file located in `data/img/`.

## Credit and Problems
ab-web-addon was made using Bootswatch themes for Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

