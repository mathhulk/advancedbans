<?php

die(json_encode(["PunishmentHistory" => (AdvancedBan::getDatabase( ))->getData("PunishmentHistory"), "Punishments" => (AdvancedBan::getDatabase( ))->getData("Punishments")]));