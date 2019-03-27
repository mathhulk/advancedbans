Simple and sleek website panel for AdvancedBan.
* Example can be found at [here](https://mathhulk.me/advancedbans/example).

## Notable Features
* Self-host
* Support multiple AdvancedBan versions
  * Legacy version 1.2.5
  * Stable version 2.1.5
  * Beta version 2.1.6
* Themes
  * Beautiful default and contributor themes
  * Create custom themes
  * User theme selection
* Languages
  * Default contributor languages
  * Create custom languages
  * User language selection
* Punishments
  * Search
    * Search punishment status
    * Search punishment type
    * Search punishment through input for name, reason and operator
    * Mix and match multiple queries during each search
* Players
  * Updated in a 5 second interval
  * Configure server host address and port
  * Optional query for older servers
  * Enable or disable
* Navigation
  * Configure custom support link
  * Configure custom appeal link
  * Enable or disable one or both

## Requirements
* PHP v7.2.8 recommended
* mysqlnd PHP module
* nd_mysqli PHP module
* Apache mod_rewrite (optional, can be enabled)

## Installation
Clone `advancedbans` to a local file location. Navigate to the `database.php` file, which should be located at `static\database.php`. Open the file with a text editor, such as Notepad++ for desktop or Nano for command-line. Enter the credentials for your database in the appropriate place and continue.
```php
<?php

define("DATABASE_HOST", "host");
define("DATABASE_USER", "user");
define("DATABASE_PASSWORD", "password");
define("DATABASE_DATABASE", "database");
```

Configuration options are also available for AdvancedBans. These options allow you to change how AdvancedBans functions. The configuration file for AdvancedBans is located at `static\configuration.json`. Once you have made changes to the configuration file, I would suggest placing the configuration file in a JSON validator to make sure you have not removed something you should not have.

Please note that the **version** must be changed from **stable** to **legacy** or **beta** in order to use AdvancedBans with AdvancedBan version 1.2.5 or 2.1.6. **Stable** denotes use of AdvancedBan version 2.1.5.
```json
{
    "version": "stable",
    "mod_rewrite": false,
    "default": {
        "theme": "photon",
        "language": "en-US"
    },
    "language": {
        "title": "AdvancedBans",
        "description": "Simple and sleek punishment panel for AdvancedBan."
    },
    "player_count": {
        "enabled": true,
        "query": false,
        "host": "mc.hypixel.net",
        "port": "25565"
    },
    "navigation": {
        "contact": {
            "enabled": true,
            "link": "http://example.com/contact"
        },
        "appeal": {
            "enabled": true,
            "link": "http://example.com/appeal"
        }
    }
}
```

## Languages
Translating Advancedban Panel is simple. Languages are located in `static\languages` and all language files follow a simple format. To translate Advancedban Panel for yourself, create a new file for your language. For example, `en-US.json` is used for the English language used in the United States. Then, use the following template to make your translations.
```json
{
	"language": "English",
	"collection": {
		"punishments": "Punishments",
		"support": "Support",
		"contact": "Contact",
		"appeal": "Appeal",
		"credit": "Credit",
		"themes": "Themes",
		"default": "Default",
		"languages": "Languages",
		"players": "Players",
		"search": "Search",
		"copy": "Copy",
		"copied": "Copied",
		"inactive": "Inactive",
		"active": "Active",
		"first": "First",
		"previous": "Previous",
		"next": "Next",
		"last": "Last",
		"name": "Name",
		"reason": "Reason",
		"operator": "Operator",
		"date": "Date",
		"expires": "Expires",
		"type": "Type",
		"status": "Status",
		"ban": "Ban",
		"temp_ban": "Temp. Ban",
		"ip_ban": "I.P. Ban",
		"mute": "Mute",
		"temp_mute": "Temp. Mute",
		"warning": "Warning",
		"temp_warning": "Temp. Warning",
		"kick": "Kick",
		"error_no_punishments": "No punishments could be listed on this page",
		"error_not_evaluated": "N/A"
	}
}
```
Consider translating AdvancedBans into a language you are fluent in. Create a pull request and I will merge the language into the master branch.

## Themes
Like translating AdvancedBans, theming AdvancedBans is also simple. However, AdvancedBans will always load the core files for Bootstrap and will follow a Bootstrap HTML structure. Themes are stored in `static\themes` and the following is an example of the file structure for a theme.
```
themes /
\ - photon /
    | - css /
        \ - photon.css
    | - img
    | - js
    \ - configuration.json
```
Static stylesheets and scripts should be placed in the appropriate `css` and `js` folders. As noted before, AdvancedBans will always load core Bootstrap files and jQuery before custom theme stylesheets and scripts.

The `configuration.json` file for your theme should follow this template.
```json
{
	"theme": "Photon",
	"creator": "mathhulk"
}
```

## Icons
To change the icons for AdvancedBans, replace the icon files located in `static\resources\images` and `static\resources\images\icons` and the `favicon.ico` file using a tool like https://www.favicon-generator.org.

## Credit
The author of AdvancedBan is Leoko. Find AdvancedBan on [SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/).