<?php
session_start();
session_destroy(); //Destroy the current login session.
header('Location: login.php');
?>