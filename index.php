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

$types = array('ban','temp_ban','mute','temp_mute','warning','temp_warning','kick');

if(isset($_GET['type']) && in_array(strtolower($_GET['type']),$types)) {
	$types = array(strtolower($_GET['type']));
}
?>
<html lang="en">
	<head>
		<title><?php echo $info['title']; ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
			  <a class="navbar-brand" href="#"><?php echo $info['title']; ?></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="#">Punishments</a></li>
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
				<p><a href="index.php" class="btn btn-primary btn-md">All</a><a href="index.php?type=ban" class="btn btn-primary btn-md">Bans</a><a href="index.php?type=kick" class="btn btn-primary btn-md">Kicks</a><a href="index.php?type=temp_ban" class="btn btn-primary btn-md">Temp-Bans</a><a href="index.php?type=mute" class="btn btn-primary btn-md">Mutes</a><a href="index.php?type=temp_mute" class="btn btn-primary btn-md">Temp-Mutes</a><a href="index.php?type=warning" class="btn btn-primary btn-md">Warnings</a><a href="index.php?type=temp_warning" class="btn btn-primary btn-md">Temp-Warnings</a></p>
			</div>
			
			<div class="jumbotron">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Username</th>
							<th>UUID</th>
							<th>Reason</th>
							<th>Operator</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` ORDER BY id DESC"); //Grab data from the MYSQL database.
						
						while($row = mysqli_fetch_array($result)) { //Fetch colums from each row of the MYSQL database.
							if($page['count'] < $page['max'] && $page['count'] >= $page['min'] && strpos($row['name'],'.') == FALSE && in_array(strtolower($row['punishmentType']),$types)) { 
								$page['count'] = $page['count'] + 1; //For some reason, $page['count']++ won't work. *shrugs*
								echo "<tr><td>".$row['name']."</td><td>".$row['uuid']."</td><td>".$row['reason']."</td><td>".$row['operator']."</td><td>".str_replace('_','-',$row['punishmentType'])."</td></tr>";
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
						echo "<a href='index.php?p=".($page['number'] - 1)."&type=".$_GET['type']."' class='btn btn-primary btn-md'>Previous Page</a>";
					}
					
					if(($page['count'] - 1) == $page['max']) { //Display a next page button if the total punishments is more than that of the current page.
						echo "<a href='index.php?p=".($page['number'] + 1)."&type=".$_GET['type']."' class='btn btn-primary btn-md'>Next Page</a>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>