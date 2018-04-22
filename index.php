<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require_once "include/database.php";
require_once "AdvancedBan/Configuration.php";
require_once "AdvancedBan/Constraint.php";
require_once "AdvancedBan/Cookie.php";
require_once "AdvancedBan/Database.php";
require_once "AdvancedBan/Language.php";
require_once "AdvancedBan/Punishment.php";
require_once "AdvancedBan/Request.php";
require_once "AdvancedBan/Session.php";
require_once "AdvancedBan/Theme.php";
require_once "AdvancedBan/Usage.php";
require_once "AdvancedBan/UserCache.php";
require_once "AdvancedBan/Page.php";
require_once "AdvancedBan/External/PtcQueryBuilder.php";
require_once "AdvancedBan/AdvancedBan.php";

AdvancedBan::initialize(__DIR__);