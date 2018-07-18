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
		<link rel="stylesheet" href="assets/css/ab-web-addon.css" media="screen">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="screen">
		
		<?php
		
		foreach(glob("include/themes/" . (isset($_COOKIE["ab-web-addon_theme"]) ? $_COOKIE["ab-web-addon_theme"] : $__public["default"]["theme"]) . "/css/*") as $stylesheet) {
			
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
					<li><a href="./graphs"><i class="fa fa-area-chart" aria-hidden="true"></i> <?= getLocale("graphs", "Graphs") ?></a></li>
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
							<li><a href="./scripts/theme?default"><?= getLocale("default", "Default") ?></a></li>
							<li class="divider"><!-- divide --></li>
							<?php
							
							foreach(glob("include/themes/*") as $theme) {
								
								$configuration = json_decode(file_get_contents($theme . "/configuration.json"), true);
								
								?>
								<li <?= isset($_COOKIE["ab-web-addon_theme"]) && basename($theme) == $_COOKIE["ab-web-addon_theme"] ? "class=\"active\"" : "" ?>>
									<a href="./scripts/theme?set=<?= basename($theme) ?>"><?= htmlspecialchars($configuration["name"]) ?> <span class="badge"><?= htmlspecialchars($configuration["author"]) ?></span></a>
								</li>
								<?php
							
							}
							
							?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language" aria-hidden="true"></i> <?= getLocale("languages", "Languages") ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="./scripts/language?default"><?= getLocale("default", "Default") ?></a></li>
							<li class="divider"><!-- divide --></li>
							<?php
							
							foreach(glob("include/languages/*") as $language) {
								
								$configuration = json_decode(file_get_contents($language), true);
								
								?>
								<li <?= isset($_COOKIE["ab-web-addon_language"]) && basename($language, ".json") == $_COOKIE["ab-web-addon_language"] ? " class=\"active\"" : "" ?>>
									<a href="./scripts/language?set=<?= basename($language, ".json") ?>"><?= htmlspecialchars($configuration["name"]) ?> <span class="badge"><?= htmlspecialchars($configuration["author"]) ?></span></a>
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
							<li><a target="_blank" href="https://mathhulk.net">mathhulk</a></li>
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
				
				foreach(getCategories( ) as $category) {

					?>
					<a href="./<?= $category !== "all" ? "?search=" . $category : "" ?>" class="btn btn-primary btn-md"><?= getLocale($category . ($category !== "all" ? "s" : ""), $category . ($category !== "all" ? "s" : "")) ?> <span class="badge"><?= mysqli_num_rows(fetchResult($category !== "all" ? $category : false)) ?></span></a>
					<?php
					
				}
				
				?>
			</div>
			
			<div class="jumbotron">
				<form method="get" action="user">
					<div class="input-group">
						<input type="text" maxlength="50" name="search" class="form-control" placeholder="<?= getLocale("search", "Search") ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><?= getLocale("submit", "Submit") ?></button>
						</span>
					</div>
				</form>
			</div>
			
			<div class="jumbotron">
				<div class="table-wrapper">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<?= $__public["skull"] === true ? "<th> </th>" : "" ?>
								<th><?= getLocale("username", "Username") ?></th>
								<th><?= getLocale("reason", "Reason") ?></th>
								<?= $__public["skull"] === true ? "<th> </th>" : "" ?>
								<th><?= getLocale("operator", "Operator") ?></th>
								<th><?= getLocale("date", "Date") ?></th>
								<th><?= getLocale("end", "End") ?></th>
								<th><?= getLocale("type", "Type") ?></th>
								<th class="text-right"><?= getLocale("status", "Status") ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							
							$punishments = fetchResult(empty($_GET["search"]) ? false : $_GET["search"]);
							$pagination = new Pagination(empty($_GET["page"]) ? 1 : $_GET["page"], $__public["pagination"]["per"], mysqli_num_rows($punishments));
							
							if(mysqli_num_rows($punishments) === 0) {
								
								?>
								<tr>
									<?= $__public["skull"] === true ? "<td>-</td>" : "" ?>
									<td><?= getLocale("error_no_punishments", "No punishments could be listed on this page") ?></td>
									<td>-</td>
									<?= $__public["skull"] === true ? "<td>-</td>" : "" ?>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
									<td class="text-right">-</td>
								</tr>
								<?php
								
							} else {
								
								while($punishment = mysqli_fetch_array($punishments)) {
									
									?>
									<tr>
										<?php
										
										if($__public["skull"] === true) {
											
											?>
											<td class="text-center"><img src="<?= getSkull(getUuid($punishment["name"])) ?>" alt="<?= $punishment["name"] ?>"></td>
											<?php
											
										}
										
										?>
										<td><a href="./user?search=<?= $punishment["name"] ?>"><?= $punishment["name"] ?></a></td>
										<td><?= $punishment["reason"] ?></td>
										<?php
										
										if($__public["skull"] === true) {
											
											?>
											<td class="text-center"><img src="<?= getSkull(getUuid($punishment["operator"])) ?>" alt="<?= $punishment["operator"] ?>"></td>
											<?php
											
										}
										
										?>
										<td><?= $punishment["operator"] ?></td>
										<td><?= convertDateTime($punishment["start"], "F jS, Y") ?> <span class="badge"><?= convertDateTime($punishment["start"], "g:i A") ?></span></td>
										<td><?= isset($punishment["end"]) ? convertDateTime($punishment["end"], "F jS, Y") . " <span class=\"badge\">" . convertDateTime($punishment["end"], "g:i A") . "</span>" : getLocale("error_not_evaluated", "N/A") ?></td>
										<td><?= getLocale(strtolower($punishment["punishmentType"]), $punishment["punishmentType"]) ?></td>
										<td><?= isActive($punishment["start"], $punishment["end"]) ? getLocale("active", "Active") : getLocale("inactive", "Inactive") ?></td>
									</tr>
									<?php
									
								}
								
							}
							
							?>
						</tbody>
					</table>
					<div class="text-center">
						<ul class="pagination">
							<?php
							
							if($pagination->page > 1) {
								
								?>
								<li><a href="?page=1<?= !empty($_GET["search"]) ? "&search=" . $_GET["search"] : "" ?>"><i class="fa fa-angle-left"></i> <?= getLocale("first", "First") ?></a></li>
								<li><a href="?page=<?= ($pagination->page - 1) . (!empty($_GET["search"]) ? "&search=" . $_GET["search"] : "") ?>"><i class="fa fa-angle-double-left"></i> <?= getLocale("previous", "Previous") ?></a></li>
								<?php
								
							}
							
							foreach($pagination->getPages($__public["pagination"]["length"]) as $page) {
								
								?>
								<li <?= $page === $pagination->page ? "class=\"active\"" : "" ?>><a href="?page=<?= $page . (!empty($_GET["search"]) ? "&search=" . $_GET["search"] : "") ?>"><?= $page ?></a></li>
								<?php
								
							}
							
							if($pagination->page < $pagination->pages) {
								
								?>
								<li><a href="?page=<?= ($pagination->page + 1) . (!empty($_GET["search"]) ? "&search=" . $_GET["search"] : "") ?>"><?= getLocale("next", "Next") ?> <i class="fa fa-angle-right"></i></a></li>
								<li><a href="?page=<?= $pagination->pages . (!empty($_GET["search"]) ? "&search=" . $_GET["search"] : "") ?>"><?= getLocale("last", "Last") ?> <i class="fa fa-angle-double-right"></i></a></li>
								<?php
								
							}
							
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/clipboard.min.js"></script>
		<script type="text/javascript" src="assets/js/ab-web-addon.js"></script>
		
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
			<script type="text/javascript" src="<?= $script ?>"> </script>
			<?php
			
		}
		
		?>
	</body>
</html>