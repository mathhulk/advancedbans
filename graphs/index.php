<?php
require("../database.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $lang['title']; ?> - <?php echo $lang['graphs']; ?></title>
		<link rel="shortcut icon" href="../data/img/icon.png" type="image/x-icon">
		<link rel="icon" href="../data/img/icon.png" type="image/x-icon">
		<link rel="stylesheet" href="../data/css/bootstrap.min.css">
		<link rel="stylesheet" href="../data/css/font-awesome.min.css">
		<link rel="stylesheet" href="../data/css/ab-web-addon.css">
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/<?php echo $info['theme']; ?>/bootstrap.min.css" rel="stylesheet">
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href=""><?php echo $lang['title']; ?></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="../"><?php echo $lang['punishments']; ?></a></li>
					<li class="active"><a href=""><?php echo $lang['graphs']; ?></a></li>
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
						$result = mysqli_query($con, "SELECT * FROM `".$info['history']."` WHERE ".($info['compact'] == true ? "punishmentType LIKE '%".strtoupper($type)."%'" : "punishmentType='".strtoupper($type)."'"));
						if($type == 'all') {
							$result = mysqli_query($con, "SELECT * FROM `".$info['history']."`".($info['ip-bans'] == false ? " WHERE punishmentType!='IP_BAN'" : ""));
						}
						echo '<a href="../?type='.$type.'" class="btn btn-primary btn-md">'.strtoupper($lang[$type.($type != 'all' ? 's' : '')]).' <span class="badge">'.mysqli_num_rows($result).'</span></a>';
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
				<div class="chart-container">
					<canvas id="chart"></canvas>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../data/js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="../data/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../data/js/chart.bundle.min.js"></script>
		<script>
		var myChart = new Chart($("#chart"), {
			type: "line",
			data: {
				<?php
				for($day = 6; $day >= 0; $day--) {
					$days[] = '"'.formatDate('l', strtotime("-".$day." days") * 1000).'"';
				}
				echo "
				labels: [".implode(", ", $days)."],
				datasets: [
				";
				foreach($types as $type) {
					$colors = array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
					$punishments = array();
					for($day = 6; $day >= 0; $day--) {
						$rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `".$info['history']."` WHERE ".($info['compact'] == true ? "punishmentType LIKE '%".strtoupper($type)."%'" : "punishmentType='".strtoupper($type)."'")." AND start BETWEEN '".(strtotime("-".$day." days") * 1000)."' AND '".(strtotime("-".($day - 1)." days") * 1000)."'"));
						if($type == 'all') {
							$rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `".$info['history']."` WHERE start BETWEEN '".(strtotime("-".$day." days") * 1000)."' AND '".(strtotime("-".($day - 1)." days") * 1000)."'".($info['ip-bans'] == false ? " AND punishmentType!='IP_BAN' " : "")));
						}
						$punishments[] = $rows;
					}
					$sets[] = '
					{
						label: "'.strtoupper($lang[$type.($type != 'all' ? 's' : '')]).'",
						fill: false,
						data: ['.implode(", ", $punishments).'],
						borderColor: "rgb('.implode(", ", $colors).')",
						backgroundColor: "rgb('.implode(", ", $colors).')"
					}
					';
				}
				echo implode(", ", $sets);
				?>
				]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				},
                title:{
                    display: true,
                    text: "<?php echo $lang['graph_title']; ?>"
                }
			}
		});
		</script>
	</body>
</html>