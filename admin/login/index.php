<?php
require("../../database.php");

$auth = array("id","username","role","email","key","token","trn_date","remember");
if($_POST) {
	foreach($auth as $key) {
		if(empty($_POST[$key])) {
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
			setcookie("id", base64_encode($_SESSION['username']), time() + (86400 * 30), "/");
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