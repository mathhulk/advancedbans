# ab-web-addon
A simple, but sleek, web addon for AdvancedBan.
- You can find the example [here](https://mathhulk.info/ab-web-addon).

## Main Features
- Host it on your own web server
- Easily change to themes from Bootswatch
- Easy to edit all words and phrases
- Able to search punishments by user
- Able to search punishments by type
- Easy to install

## Requirements
- PHP 5.6+ (7.0+ recommended)
- MySQLi PHP extension

## Setup
To use ab-web-addon, you must first upload ab-web-addon to your web server.
After your files have been uploaded, you must then fill out the necessary components in the database.php file.
```php
$con = mysqli_connect("host","user","password","database");
//Enter your MYSQL details here.
//Basic information.
$info = array(
	'theme'=>'yeti', //This is the name of the theme you wish to load. You can find a list of compatible themes at http://bootswatch.com/. (string)
	'table'=>'Punishments', //The table of your MYSQL database for which punishments are saved. (string)
	'history'=>'PunishmentHistory', //The table of your MYSQL database for which punishment history is saved. (string)
	'skulls'=>true, //Whether skulls should be shown next to users. This does not include the body render shown on /user/, which is always shown. (boolean)
	'compact'=>false, //Whether temporary punishments and punishments should be shown together. For example, temporary mutes and mutes would fall under one category of "mutes". (boolean)
	'ip-bans'=>true, //Whether punishments that reveal the IP address of players will be shown. (boolean)
	);
//Change the language.
$lang = array(
	//Information.
	'title'=>'AdvancedBan Web Addon',
	'description'=>'A simple, but sleek, web addon for AdvancedBan.',
	
	//General.
	'punishments'=>'Punishments',
	'credits'=>'Credits',
	'search'=>'Search for...',
	'submit'=>'Submit',
	'permanently_banned'=>'Permanently Banned',
	'until'=>'Banned until ',
	'not_banned'=>'Not Banned',
	'inactive'=>'Inactive',
	'active'=>'Active',
	
	//Pages.
	'first'=>'First',
	'previous'=>'Previous',
	'next'=>'Next',
	'last'=>'Last',
	
	//List.
	'username'=>'Username',
	'reason'=>'Reason',
	'operator'=>'Operator',
	'date'=>'Date',
	'end'=>'End',
	'type'=>'Type',
	'status'=>'Status',
	
	//Punishment.
	'ban'=>'Ban',
	'temp_ban'=>'Temp. Ban',
	'ip_ban'=>'IP Ban',
	'mute'=>'Mute',
	'temp_mute'=>'Temp. Mute',
	'warning'=>'Warning',
	'temp_warning'=>'Temp. Warning',
	'kick'=>'Kick',
	
	//Punishments.
	'all'=>'ALL',
	'bans'=>'BANS',
	'temp_bans'=>'TEMP. BANS',
	'ip_bans'=>'IP BANS',
	'mutes'=>'MUTES',
	'temp_mutes'=>'TEMP. MUTES',
	'warnings'=>'WARNINGS',
	'temp_warnings'=>'TEMP. WARNINGS',
	'kicks'=>'KICKS',
	
	//Errors.
	'error_no_punishments'=>'No punishments could be listed on this page.',
	'error_not_evaluated'=>'N/A',
	);
```
Once the database credentials, table, and base have been filled out, ab-web-addon will do the rest.

If you wish to change the favicon, replace the `icon.png` file located in `data/img/`.

## Credit and Problems
ab-web-addon was made using Bootswatch themes for Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

