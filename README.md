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
- Give certain accounts access to the dashboard

## Requirements
- PHP 5.6+ (7.0+ recommended)
- cURL PHP extension
- MySQLi PHP extension

## Setup
To use ab-web-addon, you must first upload ab-web-addon to your web server.
After your files have been uploaded, you must then fill out the necessary components in the database.php file.
```php
$con = mysqli_connect("host","username","password","database");
//Enter your MYSQL details here.

$info = array(
	'title'=>'AdvancedBan Web Addon', //This will be displayed in the title, main jumbotron, and navigation bar. (string)
	'description'=>'A simple, but sleek, web addon for AdvancedBan.', //This will be displayed under the title on all pages. (string)
	'theme'=>'yeti', //This is the name of the theme you wish to load. You can find a list of compatible themes at http://bootswatch.com/. (string)
	'table'=>'PunishmentHistory', //The table of your MYSQL database for which punishments are saved. (string)
	'base'=>'www.mathhulk.me/external/ab-web-addon', //DO NOT INCLUDE A TRAILING SLASH. The URL at which ab-web-addon is located. (string)
	'ip-bans'=>true, //Whether punishments that reveal the IP address of players will be shown. (boolean)
	'admin'=>array(
		'accounts'=>array('test') //The list of users that can log in to the dashboard. These must be active accounts from https://theartex.net. (array) (string)
		)
	);
```
Once the database credentials, table, and base have been filled out, ab-web-addon will do the rest.

## Credit and Problems
ab-web-addon was made using Bootswatch themes for Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

## Issues (please report)
- None

