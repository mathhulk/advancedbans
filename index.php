<?php
require("database.php");
?>
<html lang="en">
	<head>
		<title><?php echo $lang['title']; ?></title>
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
				<a class="navbar-brand" href=""><?php echo $lang['title']; ?></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href=""><?php echo $lang['punishments']; ?></a></li>
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
				<p>
					<?php
					foreach($types as $type) {
						$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType='".strtoupper($type)."'");
						if($type == 'all') {
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."`".($info['ip-bans'] == false ? " WHERE punishmentType!='IP_BAN'" : ""));
						}
						echo '<a href="?type='.$type.'" class="btn btn-primary btn-md">'.$lang[$type.($type != 'all' ? 's' : '')].' <span class="badge">'.mysqli_num_rows($result).'</span></a>';
					}
					?>
				</p>
			</div>
			<div class="jumbotron">
				<form method="get" action="user/">
					<div class="input-group">
						<input type="text" maxlength="50" name="user" class="form-control" placeholder="<?php echo $lang['search']; ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><?php echo $lang['submit']; ?></button>
						</span>
					</div>
				</form>
			</div>
			<div class="jumbotron">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th><?php echo $lang['username']; ?></th>
							<th><?php echo $lang['reason']; ?></th>
							<th><?php echo $lang['operator']; ?></th>
							<th><?php echo $lang['date']; ?></th>
							<th><?php echo $lang['end']; ?></th>
							<th><?php echo $lang['type']; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` ".($info['ip-bans'] == false ? "WHERE punishmentType!='IP_BAN' " : "")."ORDER BY id DESC LIMIT ".$page['min'].", 10");
						if(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types)) {
							$punishment = mysqli_real_escape_string($con, stripslashes($_GET['type']));
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType='".$punishment."' ORDER BY id DESC LIMIT ".$page['min'].", 10");
						}
						if(mysqli_num_rows($result) == 0) {
							echo '<tr><td>---</td><td>'.$lang['error_no_punishments'].'</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
						} else {
							while($row = mysqli_fetch_array($result)) {	
								$end = formatDate("F jS, Y", $row['end'])."<br><span class='badge'>".formatDate("g:i A", $row['end'])."</span>";
								if($row['end'] == '-1') {
									$end = $lang['error_not_evaluated'];
								}
								echo "<tr><td><img src='https://crafatar.com/renders/head/".$row['uuid']."?scale=2&default=MHF_Steve&overlay' alt='".$row['name']."'>".$row['name']."</td><td>".$row['reason']."</td><td>".$row['operator']."</td><td>".formatDate("F jS, Y", $row['start'])."<br><span class='badge'>".formatDate("g:i A", $row['start'])."</span></td><td>".$end."</td><td>".$lang[strtolower($row['punishmentType'])]."</td></tr>";
							}
						}
						?>
					</tbody>
				</table>
				<div class="text-center">
					<ul class='pagination'>
						<?php
						if($page['number'] > 1) {
							echo "<li><a href='?p=1".(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>&laquo; ".$lang['first']."</a></li>";
							echo "<li><a href='?p=".($page['number'] - 1).(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>&laquo; ".$lang['previous']."</a></li>";
						}
						$rows = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `".$info['table']."` ".($info['ip-bans'] == false ? "WHERE punishmentType!='IP_BAN' " : "")."ORDER BY id DESC"));
						if(isset($punishment)) {
							$rows = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE punishmentType='".$punishment."' ORDER BY id DESC"));
						}
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
							echo "<li ".($pages['count'] == $page['number'] ? 'class="active"' : '')."><a href='?p=".$pages['count'].(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>".$pages['count']."</a></li>";
							$pages['count'] = $pages['count'] + 1;
						}
						if($rows > $page['max']) {
							echo "<li><a href='?p=".($page['number'] + 1).(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>".$lang['next']." &raquo;</a></li>";
							echo "<li><a href='?p=".$pages['total'].(isset($_GET['type']) && $_GET['type'] != 'all' && in_array(strtolower($_GET['type']),$types) ? "&type=".$_GET['type'] : "")."'>".$lang['last']." &raquo;</a></li>";
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>