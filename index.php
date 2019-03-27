<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require_once "include/functions/parse.php";
require_once "include/functions/clean.php";

require_once "static/database.php";

require_once "AdvancedBans/User/Language.class.php";
require_once "AdvancedBans/User/Theme.class.php";

require_once "AdvancedBans/Storage/Cookie.class.php";

require_once "AdvancedBans/Database.class.php";
require_once "AdvancedBans/Configuration.class.php";
require_once "AdvancedBans/Template.class.php";
require_once "AdvancedBans/Request.class.php";
require_once "AdvancedBans/Network.class.php";

require_once "AdvancedBans/AdvancedBans.class.php";

AdvancedBans::initialize(__DIR__);