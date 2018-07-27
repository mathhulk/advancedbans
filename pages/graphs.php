<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
		
		<link rel="apple-touch-icon" sizes="57x57" href="../assets/img/icons/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="../assets/img/icons/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="../assets/img/icons/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/icons/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="../assets/img/icons/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="../assets/img/icons/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="../assets/img/icons/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="../assets/img/icons/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="../assets/img/icons/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="../assets/img/icons/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../assets/img/icons/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/img/icons/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../assets/img/icons/favicon-16x16.png">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="../assets/img/icons/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		
		<meta name="description" content="<?= $__public["messages"]["description"] ?>">
		<meta property="og:site_name" content="<?= $__public["messages"]["title"] ?>">
		<meta property="og:title" content="<?= getLocale("graphs", "Graphs") ?>">
		<meta property="og:image" content="../assets/img/icon.png">
		<meta property="og:description" content="<?= $__public["messages"]["description"] ?>">
		<meta property="og:url" content="//<?= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>">
		<meta property="og:type" content="website">
		
		<title><?= $__public["messages"]["title"] ?></title>
		
		<link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
		<link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="../assets/css/ab-web-addon.css" media="screen">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="screen">
		
		<?php
		
		foreach(glob("include/themes/" . (isset($_COOKIE["ab-web-addon_theme"]) ? $_COOKIE["ab-web-addon_theme"] : $__public["default"]["theme"]) . "/css/*") as $stylesheet) {
			
			?>
			<link rel="stylesheet" href="../<?= $stylesheet ?>" media="screen">
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
				
				<a class="navbar-brand" href="../"><?= $__public["messages"]["title"] ?></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="../"><i class="fa fa-gavel" aria-hidden="true"></i> <?= getLocale("punishments", "Punishments") ?></a></li>
					<li class="active"><a href="../graphs"><i class="fa fa-area-chart" aria-hidden="true"></i> <?= getLocale("graphs", "Graphs") ?></a></li>
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
							<li><a href="../scripts/theme?default"><?= getLocale("default", "Default") ?></a></li>
							<li class="divider"><!-- divide --></li>
							<?php
							
							foreach(glob("include/themes/*") as $theme) {
								
								$configuration = json_decode(file_get_contents($theme . "/configuration.json"), true);
								
								?>
								<li <?= isset($_COOKIE["ab-web-addon_theme"]) && basename($theme) == $_COOKIE["ab-web-addon_theme"] ? "class=\"active\"" : "" ?>>
									<a href="../scripts/theme?set=<?= basename($theme) ?>"><?= htmlspecialchars($configuration["name"]) ?> <span class="badge"><?= htmlspecialchars($configuration["author"]) ?></span></a>
								</li>
								<?php
							
							}
							
							?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language" aria-hidden="true"></i> <?= getLocale("languages", "Languages") ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../scripts/language?default"><?= getLocale("default", "Default") ?></a></li>
							<li class="divider"><!-- divide --></li>
							<?php
							
							foreach(glob("include/languages/*") as $language) {
								
								$configuration = json_decode(file_get_contents($language), true);
								
								?>
								<li <?= isset($_COOKIE["ab-web-addon_language"]) && basename($language, ".json") == $_COOKIE["ab-web-addon_language"] ? " class=\"active\"" : "" ?>>
									<a href="../scripts/language?set=<?= basename($language, ".json") ?>"><?= htmlspecialchars($configuration["name"]) ?> <span class="badge"><?= htmlspecialchars($configuration["author"]) ?></span></a>
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
				<?php
				
				foreach(getCategories( ) as $punishmentType) {

					?>
					<a href="../<?= $punishmentType !== "all" ? "?search=" . $punishmentType : "" ?>" class="btn btn-primary btn-md"><?= getLocale($punishmentType . ($punishmentType !== "all" ? "s" : ""), $punishmentType . ($punishmentType !== "all" ? "s" : "")) ?> <span class="badge"><?= fetchResult(false, false, false, $punishmentType !== "all" ? $punishmentType : false, false, false)->rowCount( ) ?></span></a>
					<?php
					
				}
				
				?>
			</div>
			
			<div class="jumbotron">
				<form method="get" action="../user">
					<div class="input-group">
						<input type="text" maxlength="50" name="search" class="form-control" placeholder="<?= getLocale("search", "Search") ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><?= getLocale("submit", "Submit") ?></button>
						</span>
					</div>
				</form>
			</div>
			
			<div class="jumbotron">
				<div class="chart-container">
					<canvas id="chart"><!-- graph --></canvas>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../assets/js/clipboard.min.js"></script>
		<script type="text/javascript" src="../assets/js/ab-web-addon.js"></script>
		
		<?php
		
		if($__public["player_count"]["enabled"] === true) {
			
			?>
			<script type="text/javascript">
				updatePlayers("<?= $__public["player_count"]["server_ip"] ?>", ".players", "<?= getLocale("error_not_evaluated", "N/A") ?>");
			</script>
			<?php
		
		}
		
		foreach(glob("include/themes/" . (isset($_COOKIE["ab-web-addon_theme"]) ? $_COOKIE["ab-web-addon_theme"] : $__public["default"]["theme"]) . "/js/*") as $script) {
			
			?>
			<script type="text/javascript" src="../<?= $script ?>"> </script>
			<?php
			
		}
		
		?>
		
		<script type="text/javascript" src="../assets/js/chart.bundle.min.js"></script>
		<script type="text/javascript">
			var myChart = new Chart($("#chart"), {
				type: "line",
				data: {
					<?php
					
					for($date = 6; $date >= 0; $date--) {
						$dates[ ] = "\"" . convertDateTime("-".$date." days", "l") . "\"";
					}
					
					?>
					labels: [<?= implode(", ", $dates) ?>], datasets: [
					<?php
					
					foreach(getCategories( ) as $punishmentType) {
						$colors = array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
						$list = array( );
						
						for($date = 6; $date >= 0; $date--) {
							$list[ ] = fetchResult(false, $date, $punishmentType !== "all" ? $punishmentType : false, false, false, false)->rowCount( );
						}
						
						$sets[ ] = "{label: \"" . strtoupper(getLocale($punishmentType . ($punishmentType != "all" ? "s" : ""), $punishmentType . ($punishmentType != "all" ? "s" : ""))) . "\", fill: false, data: [" . implode(", ", $list) . "], borderColor: \"rgb(" . implode(", ", $colors) . ")\", backgroundColor: \"rgb(" . implode(", ", $colors) . ")\"}";
					}
					
					echo implode(", ", $sets);
					
					?>
					]
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					title:{
						display: true,
						text: "<?= getLocale("graph_title", "7 Days of Punishments") ?>"
					}
				}
			});
		</script>
	</body>
</html>