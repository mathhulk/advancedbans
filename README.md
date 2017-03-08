# ab-web-addon
A simple, but sleek, web addon for AdvancedBan.
- You can find the example [here](https://mathhulk.me/ab-web-addon).

## Main Features
- Host it on your own website
- Easily edit the theme and style
- Easily change the title and description
- Allow visitors to search punishments by user
- Allow visitors to search punishments by type
- Full control
- Security put in place to prevent SQL injection
- Works with all punishments
- Easy to install and easy to use
- Mobile friendly
- Link to your theartex.net accounts
- Execute console commands from the dashboard
- Manage account access
- Log all command executions

## Using the Addon
To use the AdvancedBan web addon, you must first upload all PHP pages to your site.
The database.php file is the only file that requires editing.
```php
$con = mysqli_connect("host","username","password","database");
//Enter your MYSQL details here.

$info = array(
    'title'=>'AdvancedBan Web Addon', //This will be displayed in the title, main jumbotron, and navigation bar.
    'description'=>'A simple, but sleek, web addon for AdvancedBan.', //This will be displayed under the title on all pages.
    'theme'=>'yeti', //This is the name of the theme you wish to load. You can find a list of compatible themes at http://bootswatch.com/.
    'table'=>'PunishmentHistory', //The table of your MYSQL database for which punishments are saved.
  
    //THE FOLLOWING SECTION REQUIRES WEBSENDER TO RUN (https://www.spigotmc.org/resources/websender-send-command-with-php-bungee-and-bukkit-support.33909/)
  
    'admin'=>array(
        'host'=>'127.0.0.1', //The host of your server.
        'port'=>'9876', //The port of your server. This is the port you set in the WebSender configuration file.
        'password'=>'password123', //The password of your server. This is the password you set in the WebSender configuration file.
        'accounts'=>array('test') //The list of users that can log in to the dashboard. These must be active accounts from https://theartex.net.
        )
    );

if (mysqli_connect_errno()) {
    die('Failed to connect to database.'); //Restrict access to any page if no connection is established.
}
```
Once you have correctly entered in your database details and table name, the addon should start working.

## Credit and Problems
The site theme and framework are by Bootswatch and Bootstrap.
The addon itself by [mathhulk](https://theartex.net).
All credit for AdvancedBan goes to its original author, whose link can be found on the example page.

## Issues
- None

