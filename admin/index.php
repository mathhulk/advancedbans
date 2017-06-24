<?php
require('../database.php');

if(!isset($_SESSION['id']) || !in_array($_SESSION['username'],$info['admin']['accounts'])) { //Require the user to be logged in to view this page.
	header('Location: logout.php'); die("Redirecting..."); //Prompt the user to log in if they are not.
}

$log = new SQLite3("log.sqlite"); //Connect to or create the log database.
$query = 'CREATE TABLE IF NOT EXISTS commands (id INTEGER PRIMARY KEY AUTOINCREMENT, command VARCHAR(1000) NOT NULL, username VARCHAR(100) NOT NULL, trn_date DATETIME NOT NULL)'; $result = $log->query($query); //Create a table to save commands to.
$query = 'CREATE TABLE IF NOT EXISTS accounts (id INTEGER PRIMARY KEY AUTOINCREMENT, account_name VARCHAR(1000) NOT NULL, account_id INT(11) NOT NULL, trn_date DATETIME NOT NULL)'; $result = $log->query($query); //Create a table to save account logs to. 
$rows = $log->query("SELECT COUNT(*) as count FROM accounts WHERE account_id='".$_SESSION['id']."'"); $rows = $rows->fetchArray(); $rows = $rows['count'];
if($rows == 1) {
	$query = "UPDATE accounts SET account_name='".$_SESSION['username']."', trn_date='".date("Y-m-d H:i:s")."' WHERE account_id='".$_SESSION['id']."'"; $result = $log->query($query);
} else {
	$query = "INSERT INTO accounts (account_name, account_id, trn_date) VALUES ('".$_SESSION['username']."','".$_SESSION['id']."','".date("Y-m-d H:i:s")."')"; $result = $log->query($query);
}
	
if($_POST && isset($_SESSION['id'])) { //Check if a command was executed and the visitor is logged in.
    $cmd = new WebsenderAPI($info['admin']['host'],$info['admin']['password'],$info['admin']['port']); //Connect to the server via WebSender.
    if($cmd->connect()) { //Attempt a connection to the server via WebSender.
        $cmd->sendCommand($_POST['command']); //Execute the command via WebSender.
		$query = "INSERT INTO commands (username, command, trn_date) VALUES ('".$_SESSION['username']."', '".$_POST['command']."', '".date('Y-m-d H:i:s')."')"; $result = $log->query($query); //Log the executed command.
    } else {
        $announce = "A connection to the server could not be established"; //Display the error to the user.
	}
    $cmd->disconnect(); //Disconnect from the server via WebSender.
}
	
if(isset($_GET['p']) && is_numeric($_GET['p'])) {
	$page = array(
		'max'=>$_GET['p']*25, //The multiple is the maximum amount of results on a single page.
		'min'=>($_GET['p'] - 1)*25,
		'number'=>$_GET['p'],
		'posts'=>0,
		'count'=>0);
}else{
	$page = array(
		'max'=>'25', //The maximum amount of results on a single page.
		'min'=>'0',
		'number'=>'1',
		'posts'=>0,
		'count'=>0);
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
			
			<div class="jumbotron">
				<form method="post" action="index.php">
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
								$query = 'SELECT * FROM commands ORDER BY id DESC'; $result = $log->query($query); //Select the commands from the SQLite database.
								
								$rows = $log->query("SELECT COUNT(*) as count FROM commands"); $rows = $rows->fetchArray(); $rows = $rows['count']; //Grab the amount of results to be used in pagination.
								while($row = $result->fetchArray()) { //Fetch colums from each row of the database.
									if($page['count'] < $page['max'] && $page['count'] >= $page['min']) {
										$page['count'] = $page['count'] + 1; //For some reason, $page['count']++ won't work. *shrugs*
										
										//Start timezone change.			
										$date = new DateTime(gmdate('F jS, Y g:i A', strtotime($row['trn_date'])));
										$date->setTimezone(new DateTimeZone($_SESSION['time_zone'])); //Set the timezone of the date to that of the visitor.
										//End timezone change.
										
										echo "<tr><td>".$row['username']."</td><td>".$row['command']."</td><td class='text-right'>".$date->format("F jS, Y")."<br><span class='badge'>".$date->format("g:i A")."</span></td></tr>";
										$page['posts'] = $page['posts'] + 1;
									} else {
										$page['count'] = $page['count'] + 1;
										if($page['count'] >= $page['max']) {
											break;
										}
									}
								}
								
								if($page['posts'] == 0) { //Display an error if no commands could be found.
									echo "<tr><td>---</td><td>No commands could be listed on this page.</td><td class='text-right'>---</td></tr>";
								}
								?>
							</tbody>
						</table>
						<div class="text-center">
							<ul class='pagination'>
								<?php
								
								//Start pagination.
								if($page['number'] > 1) {
									echo "<li><a href='index.php?p=1'>&laquo; First</a></li>";
									echo "<li><a href='index.php?p=".($page['number'] - 1)."'>&laquo; Previous</a></li>";
								}
								$pages['total'] = floor($rows / 25);
								if($rows % 25 != 0 || $rows == 0) {
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
								$pages['count'] = $pages['min'];
								while($pages['count'] <= $pages['max']) {
									echo "<li ".($pages['count'] == $page['number'] ? 'class="active"' : '')."><a href='index.php?p=".$pages['count']."'>".$pages['count']."</a></li>";
									$pages['count'] = $pages['count'] + 1;
								}
								if(($page['count'] - 1) == $page['max']) {
									echo "<li><a href='index.php?p=".($page['number'] + 1)."'>Next &raquo;</a></li>";
									echo "<li><a href='index.php?p=".$pages['total']."'>Last &raquo;</a></li>";
								}
								//End pagination.
								
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
								$query = "SELECT * FROM accounts WHERE (trn_date BETWEEN '".date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) - 900)."' AND '".date("Y-m-d H:i:s")."')"; $result = $log->query($query); //Select the commands from the SQLite database.
								$total = 0;
								while($row = $result->fetchArray()) { //Fetch colums from each row of the database.
									
									//Start timezone change.				
									$date = new DateTime(gmdate('F jS, Y g:i A', strtotime($row['trn_date'])));
									$date->setTimezone(new DateTimeZone($_SESSION['time_zone'])); //Set the timezone of the date to that of the visitor.
									//End timezone change.
									
									echo "<tr><td>".$row['account_name']."</td><td class='text-right'>".$date->format("F jS, Y")."<br><span class='badge'>".$date->format("g:i A")."</span></td></tr>";
									$total = $total + 1;
								}
								
								if($total == 0) { //Display an error if no commands could be found.
									echo "<tr><td>No users found.</td><td class='text-right'>---</td></tr>";
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