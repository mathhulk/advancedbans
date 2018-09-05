<?php

$query = "SELECT * FROM " . $__private["connection"]["table"]["log"];
$statement = $__connection->query($query);
$response["log"] = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM " . $__private["connection"]["table"]["punishment"];
$statement = $__connection->query($query);
$response["punishment"] = $statement->fetchAll(PDO::FETCH_ASSOC);

die(json_encode($response));