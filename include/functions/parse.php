<?php

function parse(string $link) {
	$__configuration = AdvancedBan::getConfiguration( );
	
	return $__configuration->get(["mod_rewrite"]) === true ? $link : "?request=" . str_replace("?", "&", $link);
}