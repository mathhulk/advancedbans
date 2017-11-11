<?php
if($_POST) {
	if(!empty($_POST["user"]) && !empty($_POST["password"]) && !empty($_POST["database"]) && !empty($_POST["host"])) {
		$con = mysqli_connect($_POST["host"], $_POST["user"], $_POST["password"], $_POST["database"]);
		if(!$con) {
			$alert = "<strong>Error:</strong> Unable to connect to database.";
		} else {
			if(mysqli_query($con, "DESCRIBE `Punishments`") && mysqli_query($con, "DESCRIBE `PunishmentHistory`")) {
				$lines = file("../inc/include/database.php");
				$lines[5] = "\$con = mysqli_connect(\"".$_POST["host"]."\", \"".$_POST["user"]."\", \"".$_POST["password"]."\", \"".$_POST["database"]."\");";
				file_put_contents("../inc/include/database.php", $lines);
				header("Location: ../");
				die("Redirecting...");	
			} else {
				$alert = "<strong>Error:</strong> Punishment tables not found in database.";
			}
		}
	} else {
		$alert = "<strong>Error:</strong> Please fill in your database details.";
	}
}
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
		<meta name="description" content="Install AdvancedBan Web Addon">
		<meta property="og:site_name" content="AdvancedBan Web Addon">
		<meta property="og:title" content="Install">
		<meta property="og:image" content="../assets/img/icon.png">
		<meta property="og:description" content="Install AdvancedBan Web Addon">
		<meta property="og:url" content="http://<?php echo $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; ?>">
		<meta property="og:type" content="website">
		
		<title>AdvancedBan Web Addon - Install</title>
		
		<!-- GENERAL ICONS -->
		<link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
		<link rel="icon" href="../assets/img/icon.png" type="image/x-icon">
		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" media="screen">
		<link rel="stylesheet" href="../assets/css/ab-web-addon.css" media="screen">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="screen">
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
				
				<a class="navbar-brand" href="">AdvancedBan Web Addon</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#"><i class="fa fa-download" aria-hidden="true"></i> Install</a></li>
				</ul>
			</div>
		  </div>
		</nav>
		
		<div class="container">
			<div style="margin-top: 10vh" class="jumbotron">
				<form method="post" action="../install/">
					<h2>Database Information</h2>
					<br>
					<div class="form-group">
						<label for="host">Host</label>
						<input type="text" class="form-control" name="host">
					</div>
					<div class="form-group">
						<label for="user">User</label>
						<input type="text" class="form-control" name="user">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password">
					</div>
					<div class="form-group">
						<label for="database">Database</label>
						<input type="text" class="form-control" name="database">
					</div>
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
			<?php
			if(isset($alert)) {
				?>
				<div class="alert alert-danger">
					<?php echo $alert; ?>
				</div>
				<?php
			}
			?>
			<div class="jumbotron">
				<h2>More</h2>
				<p><small>Other settings may be changed in the configuration file, which is located at <code>/config.json</code>.</small></p>
			</div>
		</div>
		<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
	</body>
</html>