# ab-web-addon
A simple, but sleek, web addon for AdvancedBan.
- You can find the example [here](https://mathhulk.me/external/ab-web-addon).

## Main Features
- Host it on your own web server
- Easily change to themes from Bootswatch
- Easy to edit all words and phrases
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
$con = mysqli_connect("host","user","password","database");
//Enter your MYSQL details here.

//Basic information.
$info = array(
	'theme'=>'yeti', //This is the name of the theme you wish to load. You can find a list of compatible themes at http://bootswatch.com/. (string)
	'table'=>'PunishmentHistory', //The table of your MYSQL database for which punishments are saved. (string)
	'base'=>'www.example.com/bans', //DO NOT INCLUDE A TRAILING SLASH. The URL at which ab-web-addon is located. (string)
	'ip-bans'=>true, //Whether punishments that reveal the IP address of players will be shown. (boolean)
	'admin'=>array(
		'accounts'=>array('test') //The list of users that can log in to the dashboard. These must be active accounts from https://theartex.net. (array) (string)
		)
	);
	
//Change the language.
$lang = array(
	//Information.
	'title'=>'AdvancedBan Web Addon',
	'description'=>'A simple, but sleek, web addon for AdvancedBan.',
	
	//General.
	'close'=>'Close',
	'punishments'=>'Punishments',
	'credits'=>'Credits',
	'search'=>'Search for...',
	'submit'=>'Submit',
	'permanently_banned'=>'Permanently Banned',
	'until'=>'Banned until ',
	'not_banned'=>'Not Banned',
	
	//Pages.
	'first'=>'First',
	'previous'=>'Previous',
	'next'=>'Next',
	'last'=>'Last',
	
	//Authentication.
	'login'=>'Login',
	'logout'=>'Logout',
	'account'=>'Account',
	'dashboard'=>'Dashboard',
	
	//List.
	'username'=>'Username',
	'reason'=>'Reason',
	'operator'=>'Operator',
	'date'=>'Date',
	'end'=>'End',
	'type'=>'Type',
	
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
	'error'=>'Error',
	'error_login'=>'The page you are trying to access requires visitors to be signed in to access.',
	'error_access'=>'This website does not wish to allow your account access to sign in.',
	'error_no_punishments'=>'No punishments could be listed on this page.',
	'error_not_evaluated'=>'Not Evaluated',
	
	// Success.
	'success'=>'Success',
	'success_logout'=>'You have been successfully logged out of your account.',
	'success_login'=>'You have successfully signed in to your account.'
	);
```
Once the database credentials, table, and base have been filled out, ab-web-addon will do the rest.

## Credit and Problems
ab-web-addon was made using Bootswatch themes for Bootstrap.

AdvancedBan is maintained by Leoko. ([SpigotMC](https://www.spigotmc.org/resources/advancedban.8695/))

## Issues (please report)
- None

