<?php

use AdvancedBan\Configuration;

function parseLink(string $link) {
	return Configuration::get(["mod_rewrite"]) === true ? $link : "?request=" . str_replace("?", "&", $link);
}