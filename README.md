# ab-web-addon
A simple, but sleek, web addon for AdvancedBan.
- You can find the example [here](https://mathhulk.me/github/ab-web-addon).

## Main Features
- Host it on your own web server
- Select themes from Bootswatch
- Create custom themes
- Translate using language files
- List punishments by type
- List punishments by user
- View the state of a punishment
- Graphs to represent statistics
- Theme selection per user
- Language selection per user
- Live player count
- Click to copy server IP
- Custom support links

## Requirements
- PHP 5.6+ (7.0+ recommended)
- MySQLi PHP extension

## Setup
After you have uploaded all files to the wanted location on your web server, navigate to `/inc/include/` and open `database.php` with your favorite text editor. Once open, replace the MySQL connection details with those of your own MySQL database and save the file.
```php
/*
 *	MYSQL CONNECTION (host, user, password, database)
 */
$con = mysqli_connect("host", "user", "password", "database");
```
To configure the features provided, open `config.json` with your favorite text editor and change the available options to your liking.
```json
{    
    "default_theme": "yeti",
    "default_language": "en_US",
	"default_time_zone": "America/Los_Angeles",
    "table": "Punishments",
    "history_table": "PunishmentHistory",
    "skulls": true,
    "compact": false,
    "ip_bans": true,
    "messages": {
        "title": "AdvancedBan Web Addon",
        "description": "A simple, but sleek, web addon for AdvancedBan."
    },
    "player_count": {
        "enabled": true,
        "server_ip": "mc.hypixel.net"
    },
    "support": {
        "contact": {
            "enabled": true,
            "link": "http://example.com/contact"
        },
        "appeal": {
            "enabled": true,
            "link": "http://example.com/appeal"
        }
    },
	"pages": {
		"list": 25,
		"pagination": 9
	}
}
```

## Languages
Translating ab-web-addon is simple. Navigate to `/inc/languages/` and create a new file for your language, such as `pt_PT.json`. Then, copy the following template into that file. Finally, replace the terms on the right hand side with your translation. For example, `"credits": "Créditos"`.
```json
{
	"language": "English",
	"version": "2.0.1",
	"terms": {
		"punishments": "Punishments",
		"support": "Support",
		"contact": "Contact",
		"appeal": "Appeal",
		"credits": "Credits",
		"themes": "Themes",
		"reset": "Reset",
		"languages": "Languages",
		"players": "Players",
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

## Themes
Just like adding languages, creating your own themes for ab-web-addon is simple and easy. However, ab-web-addon currently only supports the dynamic loading of themes based off of Bootstrap v3. The following is an example of the theme file structure.
```
themes /
| - cerulean
| - ...
\ - yeti /
    | - css /
        \ - bootstrap.min.css
    | - js
    \ - config.json
```
All CSS stylesheets should be placed in the `css` directory and all JavaScript scripts should be placed in the `js` directory for your theme. Bootstrap will always be loaded before custom CSS stylesheets are and jQuery will always be loaded before custom JavaScript scripts are. 

In order for your theme to be available for selection, you must also include a `config.json` file that follows the following template.
```json
{
	"theme": "Cerulean",
	"version": "2.0.1",
	"author": "Bootswatch"
}
```

## Icons
If you wish to change the icon, replace the icons from `/assets/img/` and `/assets/img/icons/` using a tool like https://www.favicon-generator.org/.

## Credit and Problems
ab-web-addon was made using Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

