<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
		
		<link rel="apple-touch-icon" sizes="57x57" href="assets/img/icons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="assets/img/icons/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="assets/img/icons/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="assets/img/icons/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="assets/img/icons/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="assets/img/icons/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="assets/img/icons/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="assets/img/icons/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="assets/img/icons/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="assets/img/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="assets/img/icons/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="assets/img/icons/favicon-16x16.png">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="assets/img/icons/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		
		<meta name="description" content="<?= $__public["messages"]["description"] ?>">
		<meta property="og:site_name" content="<?= $__public["messages"]["title"] ?>">
		<meta property="og:title" content="<?= getLocale("punishments", "Punishments") ?>">
		<meta property="og:image" content="assets/img/icon.png">
		<meta property="og:description" content="<?= $__public["messages"]["description"] ?>">
		<meta property="og:url" content="//<?= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">
		<meta property="og:type" content="website">
		
		<title><?= $__public["messages"]["title"] ?></title>
		
		<link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
		<link rel="icon" href="assets/img/icon.png" type="image/x-icon">
		
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="assets/css/advancedban-panel.css" media="screen">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="screen">
		
		<?php
		
		foreach(glob("include/themes/" . (isset($_COOKIE["advancedban-panel_theme"]) ? $_COOKIE["advancedban-panel_theme"] : $__public["default"]["theme"]) . "/css/*") as $stylesheet) {
			
			?>
			<link rel="stylesheet" href="<?= $stylesheet ?>" media="screen">
			<?php
			
		}
		
		?>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<a class="navbar-brand" href="./"><?= $__public["messages"]["title"] ?></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="./"><i class="fa fa-gavel" aria-hidden="true"></i> <?= getLocale("punishments", "Punishments") ?></a></li>
					<?php
					
					if($__public["player_count"]["enabled"] === true) {
						
						?>
						<li class="clipboard" data-clipboard-text="<?= $__public["player_count"]["server_ip"] ?>">
							<a><span class="badge players"><?= getLocale("error_not_evaluated", "N/A") ?></span> <?= getLocale("players", "Players") ?></a>
						</li>
						<?php
						
					}
					
					?>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-list-alt" aria-hidden="true"></i> <?= getLocale("themes", "Themes") ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="./user/theme?default"><?= getLocale("default", "Default") ?></a></li>
							<li class="divider"><!-- divide --></li>
							<?php
							
							foreach(glob("include/themes/*") as $theme) {
								
								$configuration = json_decode(file_get_contents($theme . "/configuration.json"), true);
								
								?>
								<li <?= isset($_COOKIE["advancedban-panel_theme"]) && basename($theme) == $_COOKIE["advancedban-panel_theme"] ? "class=\"active\"" : "" ?>>
									<a href="./user/theme?set=<?= basename($theme) ?>"><?= htmlspecialchars($configuration["name"]) ?> <span class="badge"><?= htmlspecialchars($configuration["author"]) ?></span></a>
								</li>
								<?php
							
							}
							
							?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language" aria-hidden="true"></i> <?= getLocale("languages", "Languages") ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="./user/language?default"><?= getLocale("default", "Default") ?></a></li>
							<li class="divider"><!-- divide --></li>
							<?php
							
							foreach(glob("include/languages/*") as $language) {
								
								$configuration = json_decode(file_get_contents($language), true);
								
								?>
								<li <?= isset($_COOKIE["advancedban-panel_language"]) && basename($language, ".json") == $_COOKIE["advancedban-panel_language"] ? " class=\"active\"" : "" ?>>
									<a href="./user/language?set=<?= basename($language, ".json") ?>"><?= htmlspecialchars($configuration["name"]) ?> <span class="badge"><?= htmlspecialchars($configuration["author"]) ?></span></a>
								<?php
								
							}
							
							?>
						</ul>
					</li>
					<?php
					
					if($__public["support"]["contact"]["enabled"] === true || $__public["support"]["appeal"]["enabled"] == true) {
					
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <?= getLocale("support", "Support") ?> <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<?php
								
								if($__public["support"]["contact"]["enabled"] === true) {
									
									?>
									<li><a href="<?= $__public["support"]["contact"]["link"] ?>"><?= getLocale("contact", "Contact") ?></a></li>
									<?php
									
								}
								
								if($__public["support"]["appeal"]["enabled"] === true) {
									
									?>
									<li><a href="<?= $__public["support"]["appeal"]["link"] ?>"><?= getLocale("appeal", "Appeal") ?></a></li>
									<?php
									
								}
								
								?>
							</ul>
						</li>
						<?php
						
					}
					
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-code-fork" aria-hidden="true"></i> <?= getLocale("credit", "Credit") ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a target="_blank" href="https://github.com/mathhulk/advancedban-panel">GitHub</a></li>
							<li><a target="_blank" href="https://www.spigotmc.org/resources/advancedban.8695/">AdvancedBan</a></li>
							<li><a target="_blank" href="https://mathhulk.com">mathhulk</a></li>
						</ul>
					</li>
				</ul>
			</div>
		  </div>
		</nav>
		
		<div class="container">
			<div class="jumbotron">
				<h1><?= $__public["messages"]["title"] ?></h1> 
				<p><?= $__public["messages"]["description"] ?></p>
			</div>
			
			<div class="jumbotron">
				<div class="search">
					<input type="text" class="form-control" id="input" placeholder="<?= getLocale("search", "Search") ?>">
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= getLocale("type", "Type") ?> <span class="caret"></span></button>
						<ul class="dropdown-menu" aria-labelledby="type">
							<li><a data-search="ban"><?= getLocale("ban", "Ban") ?></a></li>
							<li><a data-search="temp_ban"><?= getLocale("temp_ban", "Temp. Ban") ?></a></li>
							<li><a data-search="mute"><?= getLocale("mute", "Mute") ?></a></li>
							<li><a data-search="temp_mute"><?= getLocale("temp_mute", "Temp. Mute") ?></a></li>
							<li><a data-search="warning"><?= getLocale("warning", "Warning") ?></a></li>
							<li><a data-search="temp_warning"><?= getLocale("temp_warning", "Temp. Warning") ?></a></li>
							<li><a data-search="kick"><?= getLocale("kick", "Kick") ?></a></li>
							<?php
							
							if($__public["ip_ban"] === true) {
								
								?>
								<li><a data-search="ip_ban"><?= getLocale("ip_ban", "I.P. Ban") ?></a></li>
								<?php
								
							}
							
							?>
						</ul>
					</div>
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= getLocale("status", "Status") ?> <span class="caret"></span></button>
						<ul class="dropdown-menu" aria-labelledby="status">
							<li><a data-search="active"><?= getLocale("active", "Active") ?></a></li>
							<li><a data-search="inactive"><?= getLocale("inactive", "Inactive") ?></a></li>
						</ul>
					</div>
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?= getLocale("search", "Search") ?> <span class="caret"></span></button>
						<ul class="dropdown-menu" aria-labelledby="search">
							<li><a data-search="name"><?= getLocale("name", "Name") ?></a></li>
							<li><a data-search="reason"><?= getLocale("reason", "Reason") ?></a></li>
							<li><a data-search="operator"><?= getLocale("operator", "Operator") ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="jumbotron">
				<div class="text-center">
					<ul class="pagination">
						<!-- pagination -->
					</ul>
				</div>
				<div class="table-wrapper">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th><?= getLocale("username", "Username") ?></th>
								<th><?= getLocale("reason", "Reason") ?></th>
								<th><?= getLocale("operator", "Operator") ?></th>
								<th><?= getLocale("date", "Date") ?></th>
								<th><?= getLocale("expires", "Expires") ?></th>
								<th><?= getLocale("type", "Type") ?></th>
								<th class="text-right"><?= getLocale("status", "Status") ?></th>
							</tr>
						</thead>
						<tbody>
							<!-- punishments -->
						</tbody>
					</table>
				</div>
				<div class="text-center">
					<ul class="pagination">
						<!-- pagination -->
					</ul>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/clipboard.min.js"></script>
		<script type="text/javascript" src="assets/js/advancedban-panel.js"></script>
		
		<?php
		
		foreach(glob("include/themes/" . (isset($_COOKIE["advancedban-panel_theme"]) ? $_COOKIE["advancedban-panel_theme"] : $__public["default"]["theme"]) . "/js/*") as $script) {
			
			?>
			<script type="text/javascript" src="<?= $script ?>"> </script>
			<?php
			
		}
		
		?>
	</body>
</html>