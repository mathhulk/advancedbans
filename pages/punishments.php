<?php

$query = "SELECT * FROM " . $__private["connection"]["table"]["log"];
if($__public["ip_ban"] === false) $query .= " WHERE punishmentType != 'IP_BAN'";
$statement = $__connection->query($query);
$response["log"] = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM " . $__private["connection"]["table"]["punishment"];
if($__public["ip_ban"] === false) $query .= " WHERE punishmentType != 'IP_BAN'";
$statement = $__connection->query($query);
$response["punishment"] = $statement->fetchAll(PDO::FETCH_ASSOC);

die(json_encode($response));