<?php
require("../../database.php");

foreach(array("id","token","remember") as $key) {
	if(!array_key_exists($key, $_GET)) {
		header("Location: ../../"); die("Redirecting...");
	}
}
$json = json_decode(httpPost("https://www.theartex.net/cloud/api/", array('sec'=>'validate', 'id'=>$_GET['id'], 'token'=>$_GET['token'])), true);
if(isset($json['status']) && $json['status'] == "success") {
	if(in_array($json['data']['username'], $info['admin']['accounts'])) {
		$_SESSION['id'] = $_GET['id'];
		$_SESSION['token'] = $_GET['token'];
		if($_GET['remember'] == "true") {
			$_SESSION['remember'] = "true";
			setcookie("id", base64_encode($_GET['id']), time() + (86400 * 30), "/");
			setcookie("token", base64_encode($_GET['token']), time() + (86400 * 30), "/");
		}
		header("Location: ../../?l=success"); die("Redirecting...");
	} else {
		header("Location: ../../?l=access"); die("Redirecting...");
	}
} else {
	header("Location: https://www.theartex.net/system/login/?red=".$info['base']."/admin/login/".(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "&prot=https" : "")); die("Redirecting...");
}
?>