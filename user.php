<?php
require('database.php');

if(isset($_GET['user'])) {
	$user = stripslashes($_GET['user']); $user = mysqli_real_escape_string($con,$user); //Prevent SQL injection by sanitising and escaping the string.
	$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE name='".$user."' AND punishmentType!='IP_BAN' ORDER BY id DESC"); //Grab data from the MYSQL database if a specific user is specified.
} elseif($_POST && isset($_POST['user'])) {
	$user = stripslashes($_POST['user']); $user = mysqli_real_escape_string($con,$user); //Prevent SQL injection by sanitising and escaping the string.
	$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE name='".$user."' AND punishmentType!='IP_BAN' ORDER BY id DESC"); //Grab data from the MYSQL database if a specific user is specified.
} else {
	header('Location: index.php'); die("Redirecting..."); //Transfer the visitor back to the main page if no user is specified.
}

$uuid = json_decode(file_get_contents("https://www.theartex.net/cloud/api/minecraft/?sec=uuid&username=".$user),true); //Decode the JSON response from the API.
if($uuid['status'] != 'success') {
	header('Location: index.php'); die("Redirecting..."); //Transfer the visitor back to the main page if UUID conversion failed.
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
					<li><a href="admin">Dashboard</a></li>
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
			
			<div class="jumbotron">
				<form method="post" action="user.php">
					<div class="input-group">
						<input type="text" maxlength="50" name="user" class="form-control" placeholder="Search for...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Submit</button>
						</span>
					</div>
				</form>
			</div>
			
			<div class="jumbotron">
				<div class="row">
					<div class="col-md-8 col-sm-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Reason</th>
									<th>Operator</th>
									<th>Date</th>
									<th>End</th>
									<th>Type</th>
								</tr>
							</thead>
							<tbody>
								<?php
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
										if($row['punishmentType'] == 'BAN' && !isset($banned)) { //If a ban record exists for the user, set the user to banned.
											$banned = "<small><br><br><span class='badge'>Permanently Banned</span></small>";
										} elseif($row['punishmentType'] == 'TEMP_BAN' && !isset($banned)) { //If a temporary ban record exists for the user, set the user to temporarily banned.
											$banned = "<small><br><br><span class='badge'>Banned until ".date("F jS, Y", $row['start'] / 1000)." at ".date("g:i A", $row['start'] / 1000)."</span></small>";
										}
										
										echo "<tr><td>".$row['reason']."</td><td>".$row['operator']."</td><td>".date("F jS, Y", $row['start'] / 1000)."<br><span class='badge'>".date("g:i A", $row['start'] / 1000)."</span></td><td>".$end."</td><td>".ucwords(strtolower(str_replace('_','-',$row['punishmentType'])))."</td></tr>";
										$page['posts'] = $page['posts'] + 1;
									} else {
										$page['count'] = $page['count'] + 1;
										if($page['count'] >= $page['max']) {
											break;
										}
									}
								}
								
								if($page['posts'] == 0) { //Display an error if no punishments could be found.
									echo "<tr><td>No punishments could be located.</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>";
								}
								?>
							</tbody>
						</table>
						<div class="text-center">
							<ul class='pagination'>
								<?php
								if($page['number'] != 1) { //Display a previous page button if the current page is not 1.
									echo "<li><a href='user.php?p=".($page['number'] - 1)."&user=".$user."'>&laquo; Previous Page</a></li>";
								}
								$pages = floor($rows / 25); $pagination = 1; //Fetch the number of regular pages.
								if($rows % 25 != 0) {
									$pages = $pages + 1; //Add one more page if the content will not fit on the number of regular pages.
								}
								$pages_ = $pages; //Quick fix to get the number of pages for the next page button.
								while($pages != 0) {
									echo "<li ".($pagination == $page['number'] ? 'class="active"' : '')."><a href='user.php?p=".$pagination."&user=".$user."'>".$pagination."</a></li>"; //Display the pagination.
									$pagination = $pagination + 1; $pages = $pages - 1;
								}
								if($page['number'] < $pages_) { //Display a next page button if the total punishments is more than that of the current page.
									echo "<li><a href='user.php?p=".($page['number'] + 1)."&user=".$user."'>Next Page &raquo;</a></li>";
								}
								?>
							</ul>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 text-center">
						<h2>
							<?php
							echo $user."";
							if(isset($banned)) { //Check to see if a temporary or permanent ban record is set for the user.
								echo $banned; //If so, display it.
							} else {
								echo "<small><br><br><span class='badge'>Not Banned</span></small>"; //If not, display otherwise.
							}
							?>
						</h2>
						<br><img src="https://crafatar.com/renders/body/<?php echo $uuid['data']['uuid']; ?>" alt="Skin Profile"></img>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>