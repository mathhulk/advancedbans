<?php 

/*
 *	MYSQL CONNECTION 
 *	(host, user, password, database)
 */
 
$con = mysqli_connect($__global["mysql"]["host"], $__global["mysql"]["user"], $__global["mysql"]["password"], $__global["mysql"]["database"]);

if(mysqli_connect_errno()) {
	die("An error occurred while attempting to load this page (MySQL - Unable to connect to database): ".mysqli_connect_error());
}