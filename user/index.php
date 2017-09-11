<?php
require("../load.php");

if(isset($_GET["user"])) {
	$user = json_decode(file_get_contents("https://www.theartex.net/cloud/api/minecraft/?sec=uuid&username=".$_GET['user']), true);
	if($user["status"] == "error") {
		header("Location: index.php"); 
		die("Redirecting...");
	}
} else {
	header("Location: ../"); die("Redirecting...");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $info["title"]; ?> - <?php echo $lang["punishments"]; ?></title>
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
		
		<link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
		<link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="../assets/css/ab-web-addon.css" media="screen">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		
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
				
				<a class="navbar-brand" href=""><?php echo $info["title"]; ?></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="../"><i class="fa fa-gavel"  style="padding-right:5px;" aria-hidden="true"></i><?php echo $lang["punishments"]; ?></a></li>
					<li><a href="../graphs/"><i class="fa fa-area-chart"  style="padding-right:5px;" aria-hidden="true"></i><?php echo $lang["graphs"]; ?></a></li>
					<?php
					if($info["player_count"] == true) {
						echo "<li><a><span class=\"badge players\">".$lang["error_not_evaluated"]."</span> ".$lang["players"]."</a></li>";
					}
					?>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope-open-o"  style="padding-right:5px;" aria-hidden="true"></i><?php echo $lang["support"]; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a target="_blank" href="#"><?php echo $lang["contact_us"]; ?></a></li>
							<li><a target="_blank" href="#"><?php echo $lang["ban_appeal"]; ?></a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-list-alt"  style="padding-right:5px;" aria-hidden="true"></i><?php echo $lang["themes"]; ?> <span class="caret"></span></a>
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
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-language"  style="padding-right:5px;" aria-hidden="true"></i><?php echo $lang["languages"]; ?> <span class="caret"></span></a>
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-code-fork"  style="padding-right:5px;" aria-hidden="true"></i><?php echo $lang["credits"]; ?> <span class="caret"></span></a>
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
				<h1><br><?php echo $info["title"]; ?></h1> 
				<p><?php echo $info["description"]; ?></p>
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
				<div class="row">
					<div class="col-md-8 col-sm-12">
						<div class="table-wrapper">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo $lang["reason"]; ?></th>
										<th><?php echo $lang["operator"]; ?></th>
										<th><?php echo $lang["date"]; ?></th>
										<th><?php echo $lang["end"]; ?></th>
										<th><?php echo $lang["type"]; ?></th>
										<th><?php echo $lang["status"]; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$result = mysqli_query($con,"SELECT * FROM `".$info["history_table"]."` WHERE name='".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."' ".($info["ip_bans"] == false ? "AND punishmentType!='IP_BAN' " : "")."ORDER BY id DESC LIMIT ".$page["min"].", 10");
									if(mysqli_num_rows($result) == 0) {
										echo "<tr><td>".$lang["error_no_punishments"]."</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>";
									} else {
										while($row = mysqli_fetch_array($result)) {			
											echo "<tr><td>".$row["reason"]."</td><td>".($info["skulls"] == true ? "<img src=\"https://crafatar.com/renders/head/".json_decode(file_get_contents("https://www.theartex.net/cloud/api/minecraft/?sec=uuid&username=".$row["operator"]),true)["data"]["uuid"]."?scale=2&default=MHF_Steve&overlay\" alt=\"".$row["operator"]."\">" : "").$row["operator"]."</td><td>".formatDate("F jS, Y", $row["start"])."<br><span class=\"badge\">".formatDate("g:i A", $row["start"])."</span></td><td>".($row["end"] == "-1" ? $lang["error_not_evaluated"] : formatDate("F jS, Y", $row["end"])."<br><span class=\"badge\">".formatDate("g:i A", $row["end"])."</span>")."</td><td>".$lang[strtolower($row["punishmentType"])]."</td><td>".(in_array($row["punishmentType"], array("BAN", "TEMP_BAN", "MUTE", "TEMP_MUTE", "IP_BAN", "WARNING", "TEMP_WARNING")) ? (mysqli_num_rows(mysqli_query($con, "SELECT * FROM `".$info["table"]."` WHERE uuid='".$row["uuid"]."' AND start='".$row["start"]."'")) > 0 && ($row["end"] == "-1" || date("U", formatDate("F jS, Y g:i A", (microtime(true) / 1000))) < date("U", formatDate("F jS, Y g:i A", $row["end"]))) ? $lang["active"] : $lang["inactive"]) : $lang["error_not_evaluated"])."</td></tr>";
										}
									}
									?>
								</tbody>
							</table>
							<div class="text-center">
								<ul class="pagination">
									<?php
									if($page["number"] > 1) {
										echo "<li><a href=\"?user=".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."&p=1\">&laquo; ".$lang["first"]."</a></li>";
										echo "<li><a href=\"?user=".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."&p=".($page["number"] - 1)."\">&laquo; ".$lang["previous"]."</a></li>";
									}
									$rows = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `".$info["history_table"]."` WHERE name='".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."' ".($info["ip_bans"] == false ? "AND punishmentType!='IP_BAN' " : "")."ORDER BY id DESC LIMIT ".$page["min"].", 10"));
									$pages["total"] = floor($rows / 10);
									if($rows % 10 != 0 || $rows == 0) {
										$pages["total"] = $pages["total"] + 1;
									}
									if($page["number"] < 5) {
										$pages["min"] = 1; $pages["max"] = 9;
									} elseif($page["number"] > ($pages["total"] - 8)) {
										$pages["min"] = $pages["total"] - 8; $pages["max"] = $pages["total"];
									} else {
										$pages["min"] = $page["number"] - 4; $pages["max"] = $page["number"] + 4; 
									}
									if($pages["max"] > $pages["total"]) {
										$pages["max"] = $pages["total"];
									}
									if($pages["min"] < 1) {
										$pages["min"] = 1;
									}
									$pages["count"] = $pages["min"];
									while($pages["count"] <= $pages["max"]) {
										echo "<li ".($pages["count"] == $page["number"] ? "class=\"active\"" : "")."><a href=\"?user=".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."&p=".$pages["count"]."\">".$pages["count"]."</a></li>";
										$pages["count"]++;
									}
									if($rows > $page["max"]) {
										echo "<li><a href=\"?user=".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."&p=".($page["number"] + 1)."\">".$lang["next"]." &raquo;</a></li>";
										echo "<li><a href=\"?user=".mysqli_real_escape_string($con, stripslashes($_GET["user"]))."&p=".$pages["total"]."\">".$lang["last"]." &raquo;</a></li>";
									}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 text-center">
						<h2><?php echo htmlspecialchars($_GET["user"]); ?></h2>
						<br>
						<img src="https://crafatar.com/renders/body/<?php echo $user["data"]["uuid"]; ?>" alt="Skin Profile"></img>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../assets/js/ab-web-addon.js"></script>
		
		<?php
		if($info["player_count"] == true) {
			echo "<script type=\"text/javascript\">updatePlayers(\"".$info["server_ip"]."\", \".players\", \"".$lang["error_not_evaluated"]."\");</script>";
		}
		?>
		
		<?php
		foreach(glob("../inc/themes/".(isset($_SESSION["themes"]) ? $_COOKIE["ab-theme"] : $info["default_theme"])."/js/*") as $script) {
			echo "<script type=\"text/javascript\" src=\"".$script."\"></script>";
		}
		?>
	</body>
</html>