<?php
require("../load.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
		
		<!-- ICONS -->
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
		
		<!-- INFORMATION -->
		<meta name="description" content="<?php echo $info["messages"]["description"]; ?>">
		<meta property="og:site_name" content="<?php echo $info["messages"]["title"]; ?>">
		<meta property="og:title" content="<?php echo $lang["graphs"]; ?>">
		<meta property="og:image" content="../assets/img/icon.png">
		<meta property="og:description" content="<?php echo $info["messages"]["description"]; ?>">
		<meta property="og:url" content="http://<?php echo $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; ?>">
		<meta property="og:type" content="website">
		
		<title><?php echo $info["messages"]["title"]; ?> - <?php echo $lang["graphs"]; ?></title>
		
		<!-- GENERAL ICONS -->
		<link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
		<link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="../assets/css/ab-web-addon.css" media="screen">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="screen">
		
		<?php
		foreach(glob("../inc/themes/".(isset($_COOKIE["ab-theme"]) ? $_COOKIE["ab-theme"] : $info["default_theme"])."/css/*") as $stylesheet) {
			echo "<link rel=\"stylesheet\" href=\"".$stylesheet."\" media=\"screen\">";
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
				
				<a class="navbar-brand" href=""><?php echo $info["messages"]["title"]; ?></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="../"><i class="fa fa-gavel" aria-hidden="true"></i> <?php echo $lang["punishments"]; ?></a></li>
					<li class="active"><a href="../graphs/"><i class="fa fa-area-chart" aria-hidden="true"></i> <?php echo $lang["graphs"]; ?></a></li>
					<?php
					if($info["player_count"]["enabled"] == true && !empty($info["player_count"]["server_ip"])) {
						echo "<li class=\"clipboard\" data-clipboard-text=\"".$info["player_count"]["server_ip"]."\"><a><span class=\"badge players\">".$lang["error_not_evaluated"]."</span> ".$lang["players"]."</a></li>";
					}
					?>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-list-alt" aria-hidden="true"></i> <?php echo $lang["themes"]; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../inc/scripts/theme.php?reset=true&redirect=<?php echo $_SERVER["REQUEST_URI"]; ?>"><?php echo $lang["reset"]; ?></a></li>
							<li class="divider"></li>
							<?php
							foreach(glob("../inc/themes/*") as $theme) {
								$configuration = json_decode(file_get_contents($theme."/config.json"), true);
								if($configuration["version"] == VERSION) {
									echo "<li".(isset($_COOKIE["ab-theme"]) && basename($theme) == $_COOKIE["ab-theme"] ? " class=\"active\"" : "")."><a href=\"../inc/scripts/theme.php?change=".basename($theme)."&redirect=".urlencode($_SERVER["REQUEST_URI"])."\">".htmlspecialchars($configuration["theme"])." <span class=\"badge\">".htmlspecialchars($configuration["author"])."</span></a>";
								}
							}
							?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language" aria-hidden="true"></i> <?php echo $lang["languages"]; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="../inc/scripts/language.php?reset=true&redirect=<?php echo $_SERVER["REQUEST_URI"]; ?>"><?php echo $lang["reset"]; ?></a></li>
							<li class="divider"></li>
							<?php
							foreach(glob("../inc/languages/*") as $language) {
								$configuration = json_decode(file_get_contents($language), true);
								if($configuration["version"] == VERSION) {
									echo "<li".(isset($_COOKIE["ab-lang"]) && basename($language, ".json") == $_COOKIE["ab-lang"] ? " class=\"active\"" : "")."><a href=\"../inc/scripts/language.php?change=".basename($language, ".json")."&redirect=".urlencode($_SERVER["REQUEST_URI"])."\">".htmlspecialchars($configuration["language"])."</a>";
								}
							}
							?>
						</ul>
					</li>
					<?php
					if(($info["support"]["contact"]["enabled"] == true && !empty($info["support"]["contact"]["link"])) || ($info["support"]["appeal"]["enabled"] == true && !empty($info["support"]["appeal"]["link"]))) {
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <?php echo $lang["support"]; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php
							if($info["support"]["contact"]["enabled"] == true && !empty($info["support"]["contact"]["link"])) {
								echo "<li><a href=\"".$info["support"]["contact"]["link"]."\">".$lang["contact"]."</a></li>";
							}
							if($info["support"]["appeal"]["enabled"] == true && !empty($info["support"]["appeal"]["link"])) {
								echo "<li><a href=\"".$info["support"]["appeal"]["link"]."\">".$lang["appeal"]."</a></li>";
							}
							?>
						</ul>
					</li>
					<?php
					}
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-code-fork" aria-hidden="true"></i> <?php echo $lang["credits"]; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a target="_blank" href="https://github.com/mathhulk/ab-web-addon">GitHub</a></li>
							<li><a target="_blank" href="https://www.spigotmc.org/resources/advancedban.8695/">AdvancedBan</a></li>
							<li><a target="_blank" href="https://theartex.net">mathhulk</a></li>
						</ul>
					</li>
				</ul>
			</div>
		  </div>
		</nav>
		
		<div class="container">
			<div class="jumbotron">
				<h1><br><?php echo $info["messages"]["title"]; ?></h1> 
				<p><?php echo $info["messages"]["description"]; ?></p>
				<p>
					<?php
					foreach($punishments as $punishment) {
						echo "<a href=\"../?type=".$punishment."\" class=\"btn btn-primary btn-md\">".strtoupper($lang[$punishment.($punishment != "all" ? "s" : "")])." <span class=\"badge\">".mysqli_num_rows(($punishment == "all" ? mysqli_query($con, "SELECT * FROM `".$info["history_table"]."`".($info["ip_bans"] == false ? " WHERE punishmentType!='IP_BAN'" : "")) : mysqli_query($con, "SELECT * FROM `".$info["history_table"]."` WHERE ".($info["compact"] == true ? "punishmentType LIKE '%".strtoupper($punishment)."%'" : "punishmentType='".strtoupper($punishment)."'"))))."</span></a>";
					}
					?>
				</p>
			</div>
			
			<div class="jumbotron">
				<form method="get" action="../user/">
					<div class="input-group">
						<input type="text" maxlength="50" name="user" class="form-control" placeholder="<?php echo $lang["search"]; ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><?php echo $lang["submit"]; ?></button>
						</span>
					</div>
				</form>
			</div>
			
			<div class="jumbotron">
				<div class="chart-container">
					<canvas id="chart"></canvas>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../assets/js/clipboard.min.js"></script>
		<script type="text/javascript" src="../assets/js/ab-web-addon.js"></script>
		
		<?php
		if($info["player_count"]["enabled"] == true && !empty($info["player_count"]["server_ip"])) {
			echo "<script type=\"text/javascript\">updatePlayers(\"".$info["player_count"]["server_ip"]."\", \".players\", \"".$lang["error_not_evaluated"]."\");</script>";
		}
		?>
		
		<?php
		foreach(glob("../inc/themes/".(isset($_SESSION["themes"]) ? $_COOKIE["ab-theme"] : $info["default_theme"])."/js/*") as $script) {
			echo "<script type=\"text/javascript\" src=\"".$script."\"></script>";
		}
		?>
		
		<script type="text/javascript" src="../assets/js/chart.bundle.min.js"></script>
		<script>
		var myChart = new Chart($("#chart"), {
			type: "line",
			data: {
				<?php
				for($day = 6; $day >= 0; $day--) {
					$days[] = "\"".getLocalDate(strtotime("-".$day." days"), "l")."\"";
				}
				echo "labels: [".implode(", ", $days)."], datasets: [";
				foreach($punishments as $punishment) {
					$colors = array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
					$list = array();
					for($day = 6; $day >= 0; $day--) {
						$list[] = ($type == "all" ? mysqli_num_rows(mysqli_query($con, "SELECT * FROM `".$info["history_table"]."` WHERE start BETWEEN '".(strtotime("-".$day." days") * 1000)."' AND '".(strtotime("-".($day - 1)." days") * 1000)."'".($info["ip_bans"] == false ? " AND punishmentType!='IP_BAN' " : ""))) : mysqli_num_rows(mysqli_query($con, "SELECT * FROM `".$info["history_table"]."` WHERE ".($info["compact"] == true ? "punishmentType LIKE '%".strtoupper($punishment)."%'" : "punishmentType='".strtoupper($punishment)."'")." AND start BETWEEN '".(strtotime("-".$day." days") * 1000)."' AND '".(strtotime("-".($day - 1)." days") * 1000)."'")));
					}
					$sets[] = "{label: \"".strtoupper($lang[$punishment.($punishment != "all" ? "s" : "")])."\", fill: false, data: [".implode(", ", $list)."], borderColor: \"rgb(".implode(", ", $colors).")\", backgroundColor: \"rgb(".implode(", ", $colors).")\"}";
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
                    text: "<?php echo $lang["graph_title"]; ?>"
                }
			}
		});
		</script>
	</body>
</html>