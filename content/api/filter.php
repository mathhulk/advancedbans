<?php

namespace AdvancedBan;

use AdvancedBan\Punishment;
use AdvancedBan\Request;
use AdvancedBan\Page;
use AdvancedBan;

$page = new Page(empty($_GET["page"]) ? 1 : $_GET["page"], Punishment::count($_GET));

$extra = [
	"data"=>Punishment::fetch($_GET, $page->getCurrent( )),
	"page"=>[
		"current"=>$page->getCurrent( ),
		"final"=>$page->getFinal( ),
		"pagination"=>$page->getPagination( )
		]
	];

Request::respond(200, "success", "Punishments queried", $extra);