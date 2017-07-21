<?php
require("../../database.php");

setcookie("id", "", time() - (86400 * 30), "/");
setcookie("token", "", time() - (86400 * 30), "/");
session_destroy();
header('Location: ../../?l=out'); die("Redirecting...");
?>