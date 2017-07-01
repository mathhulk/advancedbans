# ab-web-addon
A simple, but sleek, web addon for AdvancedBan.
- You can find the example [here](https://mathhulk.me/external/ab-web-addon).

## Main Features
- Host it on your own web server
- Easily change to themes from Bootswatch
- Easy to edit the title and description
- Able to search punishments by user
- Able to search punishments by type
- Easy to install
- Link directly to your theartex.net account
- Execute console commands from the dashboard (using WebSender)
- Give certain accounts access to the dashboard
- View a list of users who have recently accessed the dashboard
- View a lit of recent command executions

## Setup
To use ab-web-addon, you must first upload ab-web-addon to your web server.
After your files have been uploaded, you must then fill out the necessary components in the database.php file.
```php
$con = mysqli_connect("host","username","password","database");
//Enter your MYSQL details here.

$info = array(
	'title'=>'AdvancedBan Web Addon', //This will be displayed in the title, main jumbotron, and navigation bar.
	'description'=>'A simple, but sleek, web addon for AdvancedBan.', //This will be displayed under the title on all pages.
	'theme'=>'yeti', //This is the name of the theme you wish to load. You can find a list of compatible themes at http://bootswatch.com/.
	'table'=>'PunishmentHistory', //The table of your MYSQL database for which punishments are saved.
	'base'=>'www.mathhulk.me/external/ab-web-addon', //DO NOT INCLUDE A TRAILING SLASH. The URL at which ab-web-addon is located. 
	
	//THE FOLLOWING SECTION REQUIRES WEBSENDER TO RUN (https://www.spigotmc.org/resources/websender-send-command-with-php-bungee-and-bukkit-support.33909/)
	
	'admin'=>array(
		'host'=>'host', //The host of your server.
		'port'=>'port', //The port of your server. This is the port you set in the WebSender configuration file.
		'password'=>'password', //The password of your server. This is the password you set in the WebSender configuration file.
		'accounts'=>array('test') //The list of users that can log in to the dashboard. These must be active accounts from https://theartex.net.
		)
	);
```
Once the database credentials, table, and base have been filled out, ab-web-addon will do the rest.

## Adding IP-Bans
To protect your players, ab-web-addon will not show IP bans. To add IP bans, you must first remove both of the following comparison statements from all of the database queries: (multiple files)
```
WHERE punishmentType!='IP_BAN'

AND punishmentType!='IP_BAN'
```
I would suggest using a text editor, such as Notepad++, to remove both of these comparison statements.

After removing those comparisons, you must then add the "ip_ban" punishment to the list of punishments: (database.php)
```php
$types = array('all','ban','temp_ban','mute','temp_mute','warning','temp_warning','kick','ip_ban');
```

## Credit and Problems
ab-web-addon was made using Bootswatch themes for Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

WebSender is maintained by MediaRise. ([SpigotMC](https://www.spigotmc.org/resources/websender-send-command-with-php-bungee-and-bukkit-support.33909/))

To execute console commands from the dashboard, you must download and configure the [WebSender](https://www.spigotmc.org/resources/websender-send-command-with-php-bungee-and-bukkit-support.33909/) plugin on your server. Then, all you have to do is fill out the necessary information in the database.php file.

## Issues (please report)
- None

