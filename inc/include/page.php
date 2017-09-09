<?php 

/*
 *	PAGINATION
 */
$page = array("max"=>10, "min"=>0, "number"=>1, "posts"=>0, "count"=>0); 
if(isset($_GET["p"]) && is_numeric($_GET["p"])) {
	$page = array("max"=>$_GET["p"]*10, "min"=>($_GET["p"] - 1)*10, "number"=>$_GET["p"], "posts"=>0, "count"=>0); 
}