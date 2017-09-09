<?php 

/*
 *	MYSQL CONNECTION (host, user, password, database)
 */
$con = mysqli_connect("host", "user", "password", "database");
if(mysqli_connect_errno()) {
	die("An error occurred while attempting to load this page (MySQL - Failed to connect to database): ".mysqli_connect_error);
}