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
After you have uploaded all files to the wanted location on your web server, navigate to the variables PHP page at `/inc/include/variables.php` and open the file with a text editor. I would suggest [Notepad++](https://notepad-plus-plus.org). Here, you will be able to enter your database credentials. Save the file and you will be good to go.
```php
<?php

/*
 *	VARIABLES
 */
 
$__global = array(

	// Do not touch this unless you really want to break something.
	"version"=>"3.0.1",
	
	// MySQL Connection
	"mysql"=>array(
	
		// Connection : Host
		"host"=>"localhost",
		
		// User : Username
		"user"=>"username",
		
		// User: Password
		"password"=>"password",
		
		// Connection : Database
		"database"=>"database"
		
		),
		
	// Do not touch this unless you know what you are doing. ({UUID} and {USERNAME} are placeholders)
	"api"=>array(
		
		// API : Skull
		"skull"=>"https://visage.surgeplay.com/head/48/{UUID}",
		
		// API : Body
		"body"=>"https://visage.surgeplay.com/full/512/{UUID}",
		
		// API : UUID
		"uuid"=>"https://mcapi.cloudprotected.net/uuid/{USERNAME}"
		
		)
		
	);
```
Please be careful when editing other values, as the version controls whether or not themes and languages can be used. Along with that, I would not suggest editing the APIs if you do not have PHP experience, as for the UUID API you will have to edit the path to the UUID via PHP (json_decode) in the `/pages/index.php` and `/pages/user.php` files.

To easily configure the current available options and settings, open the `config.json` file located at `/inc/include/config.json` with a text editor. Here, you can edit the configuration for ab-web-addon. This is a JSON file, so I would suggest running the file through a JSON validator once you have finished editing it to make sure you have made no mistakes.
```json
{
    "default_theme": "yeti",
    "default_language": "en_US",
    "default_time_zone": "America/Los_Angeles",
    "table": "Punishments",
    "history_table": "PunishmentHistory",
    "skulls": false,
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
	},
	"system": {
		"https": false
	}
}
```

## Languages
Translating ab-web-addon is simple. Navigate to `/inc/languages/` and create a new file for your language, such as `pt_PT.json`. Then, copy the following template into that file. Finally, replace the terms on the right hand side with your translation. For example, `"credits": "Créditos"`.
```json
{
	"language": "English",
	"version": "3.0.1",
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
	"version": "3.0.1",
	"author": "Bootswatch"
}
```

## Icons
If you wish to change the icon, replace the icons from `/assets/img/` and `/assets/img/icons/` using a tool like https://www.favicon-generator.org/.

## Credit and Problems
ab-web-addon was made using Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

