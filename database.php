<?php
$con = mysqli_connect("host","username","password","database"); //Enter your MYSQL details here.

$info = array(
	'title'=>'AdvancedBan Web Addon', //This will be displayed in the title, main jumbotron, and navigation bar.
	'description'=>'A simple, but sleek, web addon for AdvancedBan.', //This will be displayed under the title on all pages.
	'table'=>'PunishmentHistory'); //The table of your MYSQL database for which punishments are saved.

if (mysqli_connect_errno()) {
	die('Failed to connect to database.');
}
?>