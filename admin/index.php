<?php
require('../database.php');

if(!isset($_SESSION['id']) || !in_array($_SESSION['username'],$info['admin']['accounts'])) { //Require the user to be logged in to view this page.
	header('Location: logout.php'); die("Redirecting..."); //Prompt the user to log in if they are not.
}

$log = new SQLite3("log.sqlite"); //Connect to or create the log database.
$query = 'CREATE TABLE IF NOT EXISTS commands (id INTEGER PRIMARY KEY AUTOINCREMENT, command VARCHAR(1000) NOT NULL, username VARCHAR(100) NOT NULL, trn_date DATETIME NOT NULL)'; $result = $log->query($query); //Create a table to save commands to. 
	
if($_POST && isset($_SESSION['id'])) { //Check if a command was executed and the visitor is logged in.
    $cmd = new WebsenderAPI($info['admin']['host'],$info['admin']['password'],$info['admin']['port']); //Connect to the server via WebSender.
    if($cmd->connect()) { //Attempt a connection to the server via WebSender.
        $cmd->sendCommand($_POST['command']); //Execute the command via WebSender.
		$query = "INSERT INTO commands (username, command, trn_date) VALUES ('".$_SESSION['username']."', '".$_POST['command']."', '".date('Y-m-d H:i:s')."')"; $result = $log->query($query); //Log the executed command.
    } else {
        $announce = "An error occurred while connecting to the server"; //Display the error to the user.
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['username']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
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
			
			<div class="jumbotron">
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
								
								//Start timezone API.
								$time_zone = "America/Los_Angeles";
								$tz_api = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']), true);
								if(isset($tz_api['time_zone']) && in_array($tz_api['time_zone'], timezone_identifiers_list())) {
									$time_zone = $tz_api['time_zone'];
								}
														
								$date = new DateTime(gmdate('F jS, Y g:i A', strtotime($row['trn_date'])));
								$date->setTimezone(new DateTimeZone($time_zone)); //Set the timezone of the date to that of the visitor.
								//End timezone API.
								
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
						if($page['number'] != 1) { //Display a previous page button if the current page is not 1.
							echo "<li><a href='index.php?p=".($page['number'] - 1).(isset($punishment) ? "&type=".$punishment : '')."'>&laquo; Previous Page</a></li>";
						}
						$pages = floor($rows / 25); $pagination = 1; //Fetch the number of regular pages.
						if($rows % 25 != 0) {
							$pages = $pages + 1; //Add one more page if the content will not fit on the number of regular pages.
						}
						$pages_ = $pages; //Quick fix to get the number of pages for the next page button.
						while($pages != 0) {
							echo "<li ".($pagination == $page['number'] ? 'class="active"' : '')."><a href='index.php?p=".$pagination.(isset($punishment) ? "&type=".$punishment : '')."'>".$pagination."</a></li>"; //Display the pagination.
							$pagination = $pagination + 1; $pages = $pages - 1;
						}
						if($page['number'] < $pages_) { //Display a next page button if the total punishments is more than that of the current page.
							echo "<li><a href='index.php?p=".($page['number'] + 1).(isset($punishment) ? "&type=".$punishment : '')."'>Next Page &raquo;</a></li>";
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>