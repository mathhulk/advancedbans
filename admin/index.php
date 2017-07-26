<?php
require("../database.php");

if(!isset($_SESSION['id'])) {
	header('Location: ../?l=in'); die("Redirecting...");
}
?>
<html lang="en">
	<head>
		<title><?php echo $lang['title']; ?></title>
		<link rel="stylesheet" href="../data/bootstrap.min.css">
		<link rel="stylesheet" href="../data/font-awesome.min.css">
		<script src="../data/jquery-3.1.1.min.js"></script>
		<script src="../data/bootstrap.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/<?php echo $info['theme']; ?>/bootstrap.min.css" rel="stylesheet">
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href=""><?php echo $lang['title']; ?></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="../"><?php echo $lang['punishments']; ?></a></li>
					<?php
					if(isset($_SESSION['id'])) {
						echo '
						<li class="active dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">'.$lang['account'].' <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a>'.$_SESSION['username'].'</a></li>
								<li><a href="../admin/logout/">'.$lang['logout'].'</a></li>
								<li class="divider"></li>
								<li><a href="../admin/">'.$lang['dashboard'].'</a></li>
							</ul>
						</li>
						';
					} else {
						echo '
						<li class="active dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="https://www.theartex.net/system/login/?red='.(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "https" : "http").'://'.$info['base'].'/admin/login/">'.$lang['login'].'</a></li>
							</ul>
						</li>
						';	
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $lang['credits']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="https://github.com/mathhulk/ab-web-addon">GitHub</a></li>
							<li><a href="https://www.spigotmc.org/resources/advancedban.8695/">AdvancedBan</a></li>
							<li><a href="https://theartex.net">mathhulk</a></li>
						</ul>
					</li>
				</ul>
			</div>
		  </div>
		</nav>
		<div class="container">
			<div class="jumbotron">
				<h1><br><?php echo $lang['title']; ?></h1> 
				<p><?php echo $lang['description']; ?></p>
			</div>
			<div class="jumbotron">
				<p>Statistics will be available in upcoming updates.</p>
			</div>
		</div>
	</body>
</html>