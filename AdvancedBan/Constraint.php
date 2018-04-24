<?php

namespace AdvancedBan;

// use

class Constraint {

	const PUNISHMENT_TYPE = ["BAN", "TEMP_BAN", "IP_BAN", "KICK", "MUTE", "TEMP_MUTE", "TEMP_WARNING", "WARNING"];
	const FILTER = ["name", "reason", "operator", "punishmentType", "start", "end"];
	
	const VERSION = "3.0.0-alpha";

}