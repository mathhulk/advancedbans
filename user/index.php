<?php
require("../database.php");

if(isset($_GET['user'])) {
	$json = json_decode(file_get_contents("https://www.theartex.net/cloud/api/minecraft/?sec=uuid&username=".mysqli_real_escape_string($con, stripslashes($_GET['user']))),true);
	if($json["status"] == "error") {
		header('Location: index.php'); die("Redirecting...");
	}
} else {
	header('Location: ../'); die("Redirecting...");
}
?>
<html lang="en">
	<head>
		<title><?php echo $lang['title']; ?></title>
		<link rel="stylesheet" href="../data/bootstrap.min.css">
		<link rel="stylesheet" href="../data/font-awesome.min.css">
		<link rel="stylesheet" href="../data/ab-web-addon.css">
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
				<a class="navbar-brand" href=""><?php echo $lang['title']; ?></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="../"><?php echo $lang['punishments']; ?></a></li>
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
						$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE ".($info['compact'] == true ? "punishmentType LIKE '%".strtoupper($type)."%'" : "punishmentType='".strtoupper($type)));
						if($type == 'all') {
							$result = mysqli_query($con,"SELECT * FROM `".$info['table']."`".($info['ip-bans'] == false ? " WHERE punishmentType!='IP_BAN'" : ""));
						}
						echo '<a href="../?type='.$type.'" class="btn btn-primary btn-md">'.$lang[$type.($type != 'all' ? 's' : '')].' <span class="badge">'.mysqli_num_rows($result).'</span></a>';
					}
					?>
				</p>
			</div>
			<div class="jumbotron">
				<form method="get" action="">
					<div class="input-group">
						<input type="text" maxlength="50" name="user" class="form-control" placeholder="<?php echo $lang['search']; ?>">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><?php echo $lang['submit']; ?></button>
						</span>
					</div>
				</form>
			</div>
			<div class="jumbotron">
				<div class="row">
					<div class="col-md-8 col-sm-12">
						<div class="table-wrapper">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th><?php echo $lang['reason']; ?></th>
										<th><?php echo $lang['operator']; ?></th>
										<th><?php echo $lang['date']; ?></th>
										<th><?php echo $lang['end']; ?></th>
										<th><?php echo $lang['type']; ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$result = mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE name='".mysqli_real_escape_string($con, stripslashes($_GET['user']))."' ".($info['ip-bans'] == false ? "AND punishmentType!='IP_BAN' " : "")."ORDER BY id DESC LIMIT ".$page['min'].", 10");
									if(mysqli_num_rows($result) == 0) {
										echo '<tr><td>'.$lang['error_no_punishments'].'</td><td>---</td><td>---</td><td>---</td><td>---</td></tr>';
									} else {
										while($row = mysqli_fetch_array($result)) {			
											$end = formatDate("F jS, Y", $row['end'])."<br><span class='badge'>".formatDate("g:i A", $row['end'])."</span>";
											if($row['end'] == "-1") {
												$end = $lang['error_not_evaluated'];
											}
											echo "<tr><td>".$row['reason']."</td><td>".($info['skulls'] == true ? "<img src='https://crafatar.com/renders/head/".json_decode(file_get_contents("https://www.theartex.net/cloud/api/minecraft/?sec=uuid&username=".$row['operator']),true)['data']['uuid']."?scale=2&default=MHF_Steve&overlay' alt='".$row['operator']."'>" : "").$row['operator']."</td><td>".formatDate("F jS, Y", $row['start'])."<br><span class='badge'>".formatDate("g:i A", $row['start'])."</span></td><td>".$end."</td><td>".$lang[strtolower($row['punishmentType'])]."</td></tr>";
											if(($row['punishmentType'] == 'BAN' || ($info['ip-bans'] == true && $row['punishmentType'] == 'IP_BAN')) && !isset($banned)) {
												$banned = "<small><br><br><span class='badge'>".$lang['permanently_banned']."</span></small>";
											} elseif($row['punishmentType'] == 'TEMP_BAN' && !isset($banned) && ($row['end'] / 1000) > microtime(true)) {
												$banned = "<small><br><br><span class='badge'>".$lang['until'].formatDate("F jS, Y", $row['end'])." at ".formatDate("g:i A", $row['end'])."</span></small>";
											}
										}
									}
									?>
								</tbody>
							</table>
							<div class="text-center">
								<ul class='pagination'>
									<?php
									if($page['number'] > 1) {
										echo "<li><a href='?user=".mysqli_real_escape_string($con, stripslashes($_GET['user']))."&p=1'>&laquo; ".$lang['first']."</a></li>";
										echo "<li><a href='?user=".mysqli_real_escape_string($con, stripslashes($_GET['user']))."&p=".($page['number'] - 1)."'>&laquo; ".$lang['previous']."</a></li>";
									}
									$rows = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `".$info['table']."` WHERE name='".mysqli_real_escape_string($con, stripslashes($_GET['user']))."' ".($info['ip-bans'] == false ? "AND punishmentType!='IP_BAN' " : "")."ORDER BY id DESC LIMIT ".$page['min'].", 10"));
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
										echo "<li ".($pages['count'] == $page['number'] ? 'class="active"' : '')."><a href='?user=".mysqli_real_escape_string($con, stripslashes($_GET['user']))."&p=".$pages['count']."'>".$pages['count']."</a></li>";
										$pages['count'] = $pages['count'] + 1;
									}
									if($rows > $page['max']) {
										echo "<li><a href='?user=".mysqli_real_escape_string($con, stripslashes($_GET['user']))."&p=".($page['number'] + 1)."'>".$lang['next']." &raquo;</a></li>";
										echo "<li><a href='?user=".mysqli_real_escape_string($con, stripslashes($_GET['user']))."&p=".$pages['total']."'>".$lang['last']." &raquo;</a></li>";
									}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 text-center">
						<h2>
							<?php echo (isset($banned) ? mysqli_real_escape_string($con, stripslashes($_GET['user'])).$banned : mysqli_real_escape_string($con, stripslashes($_GET['user']))."<small><br><br><span class='badge'>".$lang['not_banned']."</span></small>"); ?>
						</h2>
						<br>
						<img src="https://crafatar.com/renders/body/<?php echo $json['data']['uuid']; ?>" alt="Skin Profile"></img>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>