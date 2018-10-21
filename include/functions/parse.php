<?php

use AdvancedBan;

function parse(string $link) {
	return ((AdvancedBan::getConfiguration( )))->get(["mod_rewrite"]) === true ? $link : "?request=" . str_replace("?", "&", $link);
}