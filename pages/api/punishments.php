<?php

namespace AdvancedBan;

use AdvancedBan\Punishment;
use AdvancedBan\Request;
use AdvancedBan;

$extra = [
	"data"=>Punishment::fetch($_GET, 0)
	];

Request::respond(200, "success", "Success", $extra);