<?php

use AdvancedBan\Database;

die(json_encode(["PunishmentHistory" => Database::getData("PunishmentHistory"), "Punishments" => Database::getData("Punishments")]));