<?php

namespace AdvancedBan;

use AdvancedBan\Punishment;
use AdvancedBan\Request;
use AdvancedBan;

$final = ceil(Punishment::count($_GET) / AdvancedBan::getConfiguration( )->getValue("settings", "pagination", "limit"));
if($final === 0) {
	$final = 1;
}

$extra = [
	"data"=>Punishment::fetch($_GET, empty($_GET["page"]) ? 1 : $_GET["page"]),
	"pagination"=>[
		"current"=>empty($_GET["page"]) ? 1 : $_GET["page"],
		"final"=>$final
		]
	];

Request::respond(200, "success", "Punishments queried", $extra);