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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/<?php echo $info['theme']; ?>/bootstrap.min.css" rel="stylesheet">
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
					<li><a href="https://github.com/mathhulk/ab-web-addon">GitHub</a></li>
					<li><a href="https://www.spigotmc.org/resources/advancedban.8695/">AdvancedBan</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="https://theartex.net">made by mathhulk</a></li>
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
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."`"); $rows = mysqli_num_rows($result); //Grab the number of rows per punishment type.
						}
						echo '<a href="'.$url.'" class="btn btn-primary btn-md">'.ucwords(str_replace('_','-',$type)).($type != "all" ? "s" : "").' <span class="badge">'.$rows.'</span></a></a>'; //Print the resulting punishment type on the page.
					}
					?>
				</p>
			</div>
			
			<div class="jumbotron">
				<form method="post" action="index.php">
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
							$type = stripslashes($_GET['type']); $type = mysqli_real_escape_string($con,$type); //Prevent SQL injection by sanitising and escaping the string.
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType='".$type."' ORDER BY id DESC"); //Grab data from the MYSQL database if a specific type is specified.
						} elseif(isset($_GET['user'])) {
							$user = stripslashes($_GET['user']); $user = mysqli_real_escape_string($con,$user); //Prevent SQL injection by sanitising and escaping the string.
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE name='".$user."' ORDER BY id DESC"); //Grab data from the MYSQL database if a specific user is specified.
						} elseif($_POST && isset($_POST['user'])) {
							$user = stripslashes($_POST['user']); $user = mysqli_real_escape_string($con,$user); //Prevent SQL injection by sanitising and escaping the string.
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE name='".$user."' ORDER BY id DESC"); //Grab data from the MYSQL database if a specific user is specified.
						} else {
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` ORDER BY id DESC"); //Grab data from the MYSQL database.
						}
						
						while($row = mysqli_fetch_array($result)) { //Fetch colums from each row of the MYSQL database.
							if($page['count'] < $page['max'] && $page['count'] >= $page['min'] && strpos($row['name'],'.') == FALSE && strpos($row['uuid'],'.') == FALSE) { //Prevent showing IP addresses to improve security for the users.
								$page['count'] = $page['count'] + 1; //For some reason, $page['count']++ won't work. *shrugs*
								$end = date("F jS, Y", $row['end'] / 1000)."<br><span class='badge'>".date("g:i A", $row['end'] / 1000); //Grab the end time as a data.
								if($row['end'] == '-1') { //If the end time isn't set...
									$end = 'Not Evaluated'; //...set the end time to N/A.
								}
								echo "<tr><td>".$row['name']."</td><td>".$row['reason']."</td><td>".$row['operator']."</td><td>".date("F jS, Y", $row['start'] / 1000)."<br><span class='badge'>".date("g:i A", $row['start'] / 1000)."</span></td><td>".$end."</td><td>".ucwords(strtolower(str_replace('_','-',$row['punishmentType'])))."</td></tr>";
								$page['posts'] = $page['posts'] + 1;
							} else {
								$page['count'] = $page['count'] + 1;
								if($page['count'] >= $page['max']) {
									break;
								}
							}
						}
						
						if($page['posts'] == 0) { //Display an error if no punishments could be found.
							echo "<tr><td>---</td><td>---</td><td>No punishments could be located.</td><td>---</td><td>---</td></tr>";
						}
						?>
					</tbody>
				</table>
				<div class="text-center">
					<?php
					if($page['number'] != 1) { //Display a previous page button if the current page is not 1.
						echo "<a href='index.php?p=".($page['number'] - 1).(isset($type) ? "&type=".$type : '')."' class='btn btn-primary btn-md'>Previous Page</a>";
					}
					
					if(($page['count'] - 1) == $page['max']) { //Display a next page button if the total punishments is more than that of the current page.
						echo "<a href='index.php?p=".($page['number'] + 1).(isset($type) ? "&type=".$type : '')."' class='btn btn-primary btn-md'>Next Page</a>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>