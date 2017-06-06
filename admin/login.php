<?php
require('../database.php');

//DEVELOPER API
if(!empty($_SESSION['id'])) {
	header('Location: index.php'); die("Redirecting...");
} elseif(!empty($_POST['username']) && !empty($_POST['password'])) {
	$params = array(
		'sec'=>'login',
		'username'=>$_POST['username'],
		'password'=>md5($_POST['password']));
	$json = httpPost("https://www.theartex.net/cloud/api/index.php",$params);
	$json = json_decode($json, true);
	if($json['status'] == 'success' && in_array($_POST['username'],$info['admin']['accounts'])) {
		if($json['data']['banned'] == 'yes' || $json['data']['active'] == 'no') {
			$announce = $json['data']['username']." is either banned or deactivated";
		} else {
			$_SESSION['id'] = $json['data']['id'];
			$_SESSION['username'] = $json['data']['username'];
			$_SESSION['val'] = $json['data']['val'];
			$_SESSION['role'] = $json['data']['role'];
			$_SESSION['key'] = $json['data']['key'];
			header('Location: index.php'); die("Redirecting...");
		}
	} else {
		$announce = "Incorrect username or password";
	}
}
?>
<html lang="en">
	<head>
		<title><?php echo $info['title']; ?></title>
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
				<a class="navbar-brand" href=""><?php echo $info['title']; ?></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="../">Punishments</a></li>
					<?php
					if(isset($_SESSION['id'])) {
						echo '
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a>'.$_SESSION['username'].'</a></li>
								<li><a href="logout.php">Logout</a></li>
								<li class="divider"></li>
								<li><a href="index.php">Dashboard</a></li>
							</ul>
						</li>
						';
					} else {
						echo '
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="login.php">Login</a></li>
							</ul>
						</li>
						';	
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Credits <span class="caret"></span></a>
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
				<h1><br><?php echo $info['title']; ?></h1>
				<p><?php echo $info['description']; ?></p>
			</div>

			<?php
			if(isset($announce)) {
				echo '<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error:</strong> '.$announce.'</div>';
			}
			?>

			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="jumbotron">
						<form method="post" action="">
							<input type="text" maxlength="100" name="username" class="form-control" placeholder="Username">
							<br /> <!-- simulate an empty line -->
							<input type="password" maxlength="100" name="password" class="form-control" placeholder="Password">
							<br /> <!-- simulate an empty line -->
							<button type="submit" class="btn btn-primary">Access</button>
						</form>
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="jumbotron">
						<h4>Accounts</h4>
						<hr>
						<h5>To access the panel dashboard, please create and activate an account from <a href="https://theartex.net/system/registration.php">theartex.net</a>.</h5>
						<h5>After successfully accessing your account, add your username to the user access list found in the <i>database.php</i> file.</h5>
						<h5>Please remember that access to the panel may be denied if your account is banned or deactivated.</h5>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>