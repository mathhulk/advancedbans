<?php
require("../../database.php");

if($_POST) {
	foreach(array("id","username","role","email","key","token","trn_date","remember") as $key) {
		if(!array_key_exists($key, $_POST)) {
			header("Location: ../../"); die("Redirecting...");
		}
	}
	if(in_array($_POST['username'], $info['admin']['accounts'])) {
		$_SESSION['id'] = $_POST['id'];
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['role'] = $_POST['role'];
		$_SESSION['email'] = $_POST['email'];
		if(!empty($_POST['gravatar'])) {
			$_SESSION['gravatar'] = $_POST['gravatar'];
		}
		$_SESSION['key'] = $_POST['key'];
		$_SESSION['token'] = $_POST['token'];
		if(!empty($_POST['page'])) {
			$_SESSION['page'] = $_POST['page'];
		}
		if(!empty($_POST['last_seen'])) {
			$_SESSION['last_seen'] = $_POST['last_seen'];
		}
		if($_POST['remember'] == "true") {
			$_SESSION['remember'] = "true";
			setcookie("id", base64_encode($_SESSION['id']), time() + (86400 * 30), "/");
			setcookie("token", base64_encode($_SESSION['token']), time() + (86400 * 30), "/");
		}
		header("Location: ../../?l=success"); die("Redirecting...");
	} else {
		header("Location: ../../?l=access"); die("Redirecting...");
	}
} else {
	header("Location: ../../"); die("Redirecting...");
}
?>