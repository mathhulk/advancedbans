<?php

use AdvancedBan\User\Language;
use AdvancedBan\User\Theme;

use AdvancedBan\Storage\Cookie;

use AdvancedBan\Configuration;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		
		<title><?= Configuration::get(["messages", "title"]) ?></title>
		
		<meta name="description" content="<?= Configuration::get(["messages", "description"]) ?>">
		<meta name="application-name" content="<?= Configuration::get(["messages", "title"]) ?>">
		<!--<meta name="theme-color" content="#fafafa">-->
		<meta name="mobile-web-app-capable" content="yes">
		
		<meta property="og:title" content="<?= Language::get("punishments", "Punishments") ?>">
		<meta property="og:url" content="//<?= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">
		<meta property="og:site_name" content="<?= Configuration::get(["messages", "title"]) ?>">
		<meta property="og:image" content="//<?= $_SERVER["HTTP_HOST"] . strtok($_SERVER["REQUEST_URI"], "?") ?>static/resources/images/icon.png">
		<meta property="og:description" content="<?= Configuration::get(["messages", "description"]) ?>">
		<meta property="og:type" content="website">
		
		<meta name="msapplication-tooltip" content="<?= Configuration::get(["messages", "title"]) ?>">
		<!--<meta name="msapplication-navbutton-color" content="#fafafa">-->
		<meta name="msapplication-starturl" content=".">
		<meta name="msapplication-TileColor" content="#fafafa">
		<meta name="msapplication-TileImage" content="static/resources/images/icons/ms-icon-144x144.png">
		
		<!-- tasks -->
		
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		
		<link rel="manifest" id="manifest">
		<link rel="apple-touch-icon" sizes="57x57" href="static/resources/images/icons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="static/resources/images/icons/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="static/resources/images/icons/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="static/resources/images/icons/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="static/resources/images/icons/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="static/resources/images/icons/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="static/resources/images/icons/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="static/resources/images/icons/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="static/resources/images/icons/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="static/resources/images/icons/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="static/resources/images/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="static/resources/images/icons/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="static/resources/images/icons/favicon-16x16.png">
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" media="screen">
		<link rel="stylesheet" href="static/resources/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="static/resources/css/advancedban-panel.css" media="screen">
		
		<?php
		
		Theme::loadStatic("stylesheet", "css");
		
		?>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
			<div class="container">
				<a class="navbar-brand" href="./"><?= Configuration::get(["messages", "title"]) ?></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><!-- toggle --></span>
				</button>
				<div class="collapse navbar-collapse" id="navigation">
					<ul class="navbar-nav">
						<li class="nav-item active"><a class="nav-link" href="./"><?= Language::get("punishments", "Punishments") ?></a></li>
						<?php
						
						if(Configuration::get(["player_count", "enabled"]) === true) {
							
							?>
							<li class="nav-item clipboard" data-clipboard-text="<?= Configuration::get(["player_count", "server_ip"]) ?>">
								<a class="nav-link"><span class="badge badge-primary players"><?= Language::get("error_not_evaluated", "N/A") ?></span> <?= Language::get("players", "Players") ?></a>
							</li>
							<?php
							
						}
						
						?>
					</ul>
				
					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= Language::get("themes", "Themes") ?> <span class="caret"><!-- icon --></span></a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="./<?= parseLink("user/theme?default") ?>"><?= Language::get("default", "Default") ?></a>
								<div class="dropdown-divider"><!-- divide --></div>
								<?php
								
								foreach(glob(AdvancedBan::getRoot( ) . "/static/themes/*") as $theme) {
									
									$data = json_decode(file_get_contents($theme . "/configuration.json"), true);
									
									?>
									<a class="<?= basename($theme) === Cookie::get("theme") ? "active " : " " ?>dropdown-item" href="./<?= parseLink("user/theme?set=" . basename($theme)) ?>"><?= htmlspecialchars($data["theme"]) ?> <span class="badge badge-primary"><?= htmlspecialchars($data["creator"]) ?></span></a>
									<?php
								
								}
								
								?>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= Language::get("languages", "Languages") ?> <span class="caret"><!-- icon --></span></a>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="./<?= parseLink("user/language?default") ?>"><?= Language::get("default", "Default") ?></a>
								<div class="dropdown-divider"><!-- divide --></div>
								<?php
								
								foreach(glob(AdvancedBan::getRoot( ) . "/static/languages/*") as $language) {
									
									$data = json_decode(file_get_contents($language), true);
									
									?>
									<a class="<?= basename($language, ".json") === Cookie::get("language") ? "active " : " " ?>dropdown-item" href="./<?= parseLink("user/language?set=" . basename($language, ".json")) ?>"><?= htmlspecialchars($data["language"]) ?></a>
									<?php
									
								}
								
								?>
							</div>
						</li>
						<?php
						
						if(Configuration::get(["support", "contact", "enabled"]) === true || Configuration::get(["support", "appeal", "enabled"]) == true) {
						
							?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= Language::get("support", "Support") ?> <span class="caret"><!-- icon --></span></a>
								<div class="dropdown-menu">
									<?php
									
									if(Configuration::get(["support", "contact", "enabled"]) === true) {
										
										?>
										<a class="dropdown-item" href="<?= Configuration::get(["support", "contact", "link"]) ?>"><?= Language::get("contact", "Contact") ?></a>
										<?php
										
									}
									
									if(Configuration::get(["support", "appeal", "enabled"]) === true) {
										
										?>
										<a class="dropdown-item" href="<?= Configuration::get(["support", "appeal", "link"]) ?>"><?= Language::get("appeal", "Appeal") ?></a>
										<?php
										
									}
									
									?>
								</div>
							</li>
							<?php
							
						}
						
						?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= Language::get("credit", "Credit") ?> <span class="caret"><!-- icon --></span></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" target="_blank" href="https://github.com/mathhulk/advancedban-panel">GitHub</a>
								<a class="dropdown-item" target="_blank" href="https://www.spigotmc.org/resources/advancedban.8695/">AdvancedBan</a>
								<a class="dropdown-item" target="_blank" href="https://mathhulk.com">mathhulk</a>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="splash text-center">
			<div class="container">
				<h1><?= Configuration::get(["messages", "title"]) ?></h1> 
				<p><?= Configuration::get(["messages", "description"]) ?></p>
			</div>
		</div>
		
		<div class="content">
			<div class="search">
				<div class="container">
					<input type="text" class="form-control" id="input" placeholder="<?= Language::get("search", "Search") ?>">
					<div class="text-center">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="punishmentType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= Language::get("type", "Type") ?> <span class="caret"><!-- icon --></span></button>
							<div class="dropdown-menu" aria-labelledby="punishmentType">
								<a class="dropdown-item" data-search="ban"><?= Language::get("ban", "Ban") ?></a>
								<a class="dropdown-item" data-search="temp_ban"><?= Language::get("temp_ban", "Temp. Ban") ?></a>
								<a class="dropdown-item" data-search="mute"><?= Language::get("mute", "Mute") ?></a>
								<a class="dropdown-item" data-search="temp_mute"><?= Language::get("temp_mute", "Temp. Mute") ?></a>
								<a class="dropdown-item" data-search="warning"><?= Language::get("warning", "Warning") ?></a>
								<a class="dropdown-item" data-search="temp_warning"><?= Language::get("temp_warning", "Temp. Warning") ?></a>
								<a class="dropdown-item" data-search="kick"><?= Language::get("kick", "Kick") ?></a>
								<a class="dropdown-item" data-search="ip_ban"><?= Language::get("ip_ban", "I.P. Ban") ?></a>
							</div>
						</div>
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="punishmentStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= Language::get("status", "Status") ?> <span class="caret"><!-- icon --></span></button>
							<div class="dropdown-menu" aria-labelledby="punishmentStatus">
								<a class="dropdown-item" data-search="active"><?= Language::get("active", "Active") ?></a>
								<a class="dropdown-item" data-search="inactive"><?= Language::get("inactive", "Inactive") ?></a>
							</div>
						</div>
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="inputType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= Language::get("search", "Search") ?> <span class="caret"><!-- icon --></span></button>
							<div class="dropdown-menu" aria-labelledby="inputType">
								<a class="dropdown-item" data-search="name"><?= Language::get("name", "Name") ?></a>
								<a class="dropdown-item" data-search="reason"><?= Language::get("reason", "Reason") ?></a>
								<a class="dropdown-item" data-search="operator"><?= Language::get("operator", "Operator") ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="punishment-wrapper container">
				<div class="load text-center">
					<img src="static/resources/images/borb.gif">
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="static/resources/javascript/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="static/resources/javascript/popper.min.js"></script>
		<script type="text/javascript" src="static/resources/javascript/clipboard.min.js"></script>
		<script type="text/javascript" src="static/resources/javascript/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="static/resources/javascript/AdvancedBan/User/Language.class.js"></script>
		
		<script type="text/javascript" src="static/resources/javascript/AdvancedBan/Storage/Cookie.class.js"></script>
		
		<script type="text/javascript" src="static/resources/javascript/AdvancedBan/Configuration.class.js"></script>
		<script type="text/javascript" src="static/resources/javascript/AdvancedBan/Template.class.js"></script>
		
		<script type="text/javascript" src="static/resources/javascript/AdvancedBan/AdvancedBan.class.js"></script>
		
		<script type="text/javascript" src="static/resources/javascript/include/functions/setManifest.js"></script>
		<script type="text/javascript" src="static/resources/javascript/include/functions/setPlayers.js"></script>
		
		<script type="text/javascript" src="static/resources/javascript/advancedban-panel.js"></script>
		
		<?php
		
		Theme::loadStatic("script", "js");
		
		?>
	</body>
</html>