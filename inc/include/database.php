<?php 

/*
 *	DATABASE CONNECTION 
 *	(host, user, password, database)
 */
 
$con = mysqli_connect($__global["database"]["host"], $__global["database"]["user"], $__global["database"]["password"], $__global["database"]["database"]);

if(mysqli_connect_errno()) {
	die("An error occurred while attempting to load this page (MySQL - Unable to connect to database): ".mysqli_connect_error());
}