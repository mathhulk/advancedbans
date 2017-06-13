<?php
require('database.php');

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

$types = array('all','ban','temp_ban','mute','temp_mute','warning','temp_warning','kick'); //List the types of punishments.
?>
<html lang="en">
	<head>
		<title><?php echo $info['title']; ?></title>
		<link rel="stylesheet" href="data/bootstrap.min.css">
		<link rel="stylesheet" href="data/font-awesome.min.css">
		<script src="data/jquery-3.1.1.min.js"></script>
		<script src="data/bootstrap.min.js"></script>
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
					<li class="active"><a href="">Punishments</a></li>
					<?php
					if(isset($_SESSION['id'])) {
						echo '
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a>'.$_SESSION['username'].'</a></li>
								<li><a href="admin/logout.php">Logout</a></li>
								<li class="divider"></li>
								<li><a href="admin">Dashboard</a></li>
							</ul>
						</li>
						';
					} else {
						echo '
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="admin/login.php">Login</a></li>
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
				<p>
					<?php
					foreach($types as $type) { //Loop through the types of punishments.
						$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType='".strtoupper($type)."'"); $rows = mysqli_num_rows($result); //Grab the number of rows per punishment type.
						$url = "index.php?type=".$type; //Grab the URL for each type.
						if($type == 'all') { //If the type is all...
							$url = "index.php"; //...set the URL to the same page.
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType!='IP_BAN'"); $rows = mysqli_num_rows($result); //Grab the number of rows per punishment type.
						}
						echo '<a href="'.$url.'" class="btn btn-primary btn-md">'.ucwords(str_replace('_','-',$type)).($type != "all" ? "s" : "").' <span class="badge">'.$rows.'</span></a></a>'; //Print the resulting punishment type on the page.
					}
					?>
				</p>
			</div>
			
			<div class="jumbotron">
				<form method="get" action="user.php">
					<div class="input-group">
						<input type="text" maxlength="50" name="user" class="form-control" placeholder="Search for...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Submit</button>
						</span>
					</div>
				</form>
			</div>
			
			<div class="jumbotron">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Username</th>
							<th>Reason</th>
							<th>Operator</th>
							<th>Date</th>
							<th>End</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types)) { //Check to see if the type is in the list of types.
							$punishment = stripslashes($_GET['type']); $punishment = mysqli_real_escape_string($con,$punishment); //Prevent SQL injection by sanitising and escaping the string.
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType='".$punishment."' ORDER BY id DESC"); //Grab data from the MYSQL database if a specific type is specified.
						} else {
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType!='IP_BAN' ORDER BY id DESC"); //Grab data from the MYSQL database.
						}
						
						$rows = mysqli_num_rows($result); //Grab the amount of results to be used in pagination.
						while($row = mysqli_fetch_array($result)) { //Fetch colums from each row of the MYSQL database.
							if($page['count'] < $page['max'] && $page['count'] >= $page['min']) {
								$page['count'] = $page['count'] + 1; //For some reason, $page['count']++ won't work. *shrugs*
								
								//Start timezone API.
								$time_zone = "America/Los_Angeles";
								$tz_api = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']), true);
								if(isset($tz_api['time_zone']) && in_array($tz_api['time_zone'], timezone_identifiers_list())) {
									$time_zone = $tz_api['time_zone'];
								}
														
								$end_date = new DateTime(gmdate('F jS, Y g:i A', $row['end'] / 1000));
								$end_date->setTimezone(new DateTimeZone($time_zone)); //Set the timezone of the date to that of the visitor.
								
								$start_date = new DateTime(gmdate('F jS, Y g:i A', $row['start'] / 1000));
								$start_date->setTimezone(new DateTimeZone($time_zone)); //Set the timezone of the date to that of the visitor.
								//End timezone API.
								
								$end = $end_date->format("F jS, Y")."<br><span class='badge'>".$end_date->format("g:i A")."</span>"; //Grab the end time as a data.
								if($row['end'] == '-1') { //If the end time isn't set...
									$end = 'Not Evaluated'; //...set the end time to N/A.
								}
								echo "<tr><td><img src='https://crafatar.com/renders/head/".$row['uuid']."?scale=2&default=MHF_Steve&overlay' alt='".$row['name']."'>".$row['name']."</td><td>".$row['reason']."</td><td>".$row['operator']."</td><td>".$start_date->format("F jS, Y")."<br><span class='badge'>".$start_date->format("g:i A")."</span></td><td>".$end."</td><td>".ucwords(strtolower(str_replace('_','-',$row['punishmentType'])))."</td></tr>";
								$page['posts'] = $page['posts'] + 1;
							} else {
								$page['count'] = $page['count'] + 1;
								if($page['count'] >= $page['max']) {
									break;
								}
							}
						}
						
						if($page['posts'] == 0) { //Display an error if no punishments could be found.
							echo "<tr><td>---</td><td>No punishments could be listed on this page.</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>";
						}
						?>
					</tbody>
				</table>
				<div class="text-center">
					<ul class='pagination'>
						<?php
						
						//Start pagination.
						if($page['number'] > 1) {
							echo "<li><a href='index.php?p=1".(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>&laquo; First</a></li>";
							echo "<li><a href='index.php?p=".($page['number'] - 1).(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>&laquo; Previous</a></li>";
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
							echo "<li ".($pages['count'] == $page['number'] ? 'class="active"' : '')."><a href='index.php?p=".$pages['count'].(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>".$pages['count']."</a></li>";
							$pages['count'] = $pages['count'] + 1;
						}
						if(($page['count'] - 1) == $page['max']) {
							echo "<li><a href='index.php?p=".($page['number'] + 1).(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>Next &raquo;</a></li>";
							echo "<li><a href='index.php?p=".$pages['total'].(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>Last &raquo;</a></li>";
						}
						//End pagination.
						
						?>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
