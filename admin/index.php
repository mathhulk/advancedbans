<?php
require("../database.php");

if(!isset($_SESSION['id'])) {
	header('Location: ../?l=in'); die("Redirecting...");
}
$log = new SQLite3("log.sqlite");
$log->query('CREATE TABLE IF NOT EXISTS commands (id INTEGER PRIMARY KEY AUTOINCREMENT, command VARCHAR(1000) NOT NULL, username VARCHAR(100) NOT NULL, trn_date DATETIME NOT NULL)');
$log->query('CREATE TABLE IF NOT EXISTS accounts (id INTEGER PRIMARY KEY AUTOINCREMENT, account_name VARCHAR(1000) NOT NULL, account_id INT(11) NOT NULL, trn_date DATETIME NOT NULL)');  
$rows = $log->query("SELECT COUNT(*) as count FROM accounts WHERE account_id='".$_SESSION['id']."'"); $rows = $rows->fetchArray(); $rows = $rows['count'];
if($rows == 1) {
	$log->query("UPDATE accounts SET account_name='".$_SESSION['username']."', trn_date='".date("Y-m-d H:i:s")."' WHERE account_id='".$_SESSION['id']."'");
} else {
	$log->query("INSERT INTO accounts (account_name, account_id, trn_date) VALUES ('".$_SESSION['username']."','".$_SESSION['id']."','".date("Y-m-d H:i:s")."')");
}
if($_POST) {
    $cmd = new WebsenderAPI($info['admin']['host'],$info['admin']['password'],$info['admin']['port']);
    if($cmd->connect()) {
        $cmd->sendCommand($_POST['command']);
		$log->query("INSERT INTO commands (username, command, trn_date) VALUES ('".$_SESSION['username']."', '".$_POST['command']."', '".date('Y-m-d H:i:s')."')");
    } else {
        $announce = "A connection to the server could not be established";
	}
    $cmd->disconnect();
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
								<li><a href="logout/">Logout</a></li>
								<li class="divider"></li>
								<li><a href="">Dashboard</a></li>
							</ul>
						</li>
						';
					} else {
						echo '
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="https://www.theartex.net/system/login/?red='.$info['base'].'/admin/login/'.(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "&prot=https" : "").'">Login</a></li>
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
			<div class="jumbotron">
				<form method="post" action="">
					<div class="input-group">
						<input type="text" maxlength="1000" name="command" class="form-control" placeholder="say Hello World">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Execute</button>
						</span>
					</div>
				</form>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12">			
					<div class="jumbotron">
						<h2>Recent Executions</h2>
						<h6>All Time</h6>
						<br>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Username</th>
									<th>Command</th>
									<th class="text-right">Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = $log->query('SELECT * FROM commands ORDER BY id DESC LIMIT '.$page['min'].', 10');
								$rows = $log->query("SELECT COUNT(*) as count FROM commands LIMIT ".$page['min'].", 10"); $rows = $rows->fetchArray(); $rows = $rows['count'];
								if($rows == 0) {
									echo "<tr><td>---</td><td>No commands could be listed on this page.</td><td class='text-right'>---</td></tr>";
								} else {
									while($row = $result->fetchArray()) {	
										$date = new DateTime(gmdate('F jS, Y g:i A', strtotime($row['trn_date'])));
										$date->setTimezone(new DateTimeZone($_SESSION['time_zone']));
										echo "<tr><td>".$row['username']."</td><td>".$row['command']."</td><td class='text-right'>".$date->format("F jS, Y")."<br><span class='badge'>".$date->format("g:i A")."</span></td></tr>";
									}
								}
								?>
							</tbody>
						</table>
						<div class="text-center">
							<ul class='pagination'>
								<?php
								if($page['number'] > 1) {
									echo "<li><a href='?p=1'>&laquo; First</a></li>";
									echo "<li><a href='?p=".($page['number'] - 1)."'>&laquo; Previous</a></li>";
								}
								$rows = $log->query("SELECT COUNT(*) as count FROM commands"); $rows = $rows->fetchArray(); $rows = $rows['count'];
								$pages['total'] = floor($rows / 10);
								if($rows % 10 != 0 || $rows == 0) {
									$pages['total'] = $pages['total'] + 1;
								}
								if($page['number'] < 5) {
									$pages['min'] = 1; $pages['max'] = 9;
								} elseif($page['number'] > ($pages['total'] - 8)) {
									$pages['min'] = $pages['total'] - 8; $pages['max'] = $pages['total'];
								} else {
									$pages['min'] = $page['number'] - 4; $pages['max'] = $page['number'] + 4; 
								}
								if($pages['max'] > $pages['total']) {
									$pages['max'] = $pages['total'];
								}
								if($pages['min'] < 1) {
									$pages['min'] = 1;
								}
								$pages['count'] = $pages['min'];
								while($pages['count'] <= $pages['max']) {
									echo "<li ".($pages['count'] == $page['number'] ? 'class="active"' : '')."><a href='?p=".$pages['count']."'>".$pages['count']."</a></li>";
									$pages['count'] = $pages['count'] + 1;
								}
								if($rows > $page['max']) {
									echo "<li><a href='?p=".($page['number'] + 1)."'>Next &raquo;</a></li>";
									echo "<li><a href='?p=".$pages['total']."'>Last &raquo;</a></li>";
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="jumbotron">
						<h2>Recent Access</h2>
						<h6>Past 15 Minutes</h6>
						<br>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Username</th>
									<th class="text-right">Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = $log->query("SELECT * FROM accounts WHERE (trn_date BETWEEN '".date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) - 900)."' AND '".date("Y-m-d H:i:s")."')");
								$rows = $log->query("SELECT COUNT(*) as count FROM accounts WHERE (trn_date BETWEEN '".date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) - 900)."' AND '".date("Y-m-d H:i:s")."')"); $rows = $rows->fetchArray(); $rows = $rows['count'];
								while($row = $result->fetchArray()) {			
									$date = new DateTime(gmdate('F jS, Y g:i A', strtotime($row['trn_date'])));
									$date->setTimezone(new DateTimeZone($_SESSION['time_zone']));
									echo "<tr><td>".$row['account_name']."</td><td class='text-right'>".$date->format("F jS, Y")."<br><span class='badge'>".$date->format("g:i A")."</span></td></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>