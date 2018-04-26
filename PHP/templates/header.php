<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<title><?php
			$page = ((isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 'index');
			$title = WEBSITE_TITLE." - ".((!empty($pagetitles[$page])) ? $pagetitles[$page] : '404 Not Found');
			echo $title;
		?></title>
		
		
		<!-- BOOTSTRAP STYLES-->
		<link href="assets/css/bootstrap.css" rel="stylesheet" />
		<!-- FONTAWESOME STYLES-->
		<link href="assets/css/font-awesome.css" rel="stylesheet" />
		<!-- CUSTOM STYLES-->
		<link href="assets/css/custom.css" rel="stylesheet" />
		<!-- GOOGLE FONTS-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
		
		<!-- JQUERY SCRIPTS -->
		<script src="assets/js/jquery-1.10.2.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="?page=home"><?=SERVER_NAME?></a> 
				</div>
				<div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
					<?php if ($CP->Loggedin) { ?>
					<a href="?page=logout" class="btn btn-danger square-btn-adjust">Logout</a>
					<?php } ?>
				</div>
			</nav>   
			<!-- /. NAV TOP  -->
			
			<nav class="navbar-default navbar-side" role="navigation">
				<div class="sidebar-collapse">
					<ul class="nav" id="main-menu">
						<?php if ($CP->Loggedin) { ?>
						<li class="text-center">
							<div class="alert alert-info">
								<b>Schon gewusst?</b><br>
								<?php
									if (isset($_COOKIE['lastInfo']) && !empty($_COOKIE['lastInfo'])) {
										$info = $_COOKIE['lastInfo'] + 1;
									} else {
										$info = 1;
									}
									if ($info > 6) {
										$info = 1;
									}
									setcookie("lastInfo", $info, time()+99999);
									
									switch ($info) {
										case 1:
											$whereFIX = ((SCRIPT_TYPE=='ultimate') ? 'UID' : 'id');
											$sql = $mySQLcon->query("SELECT * FROM players ORDER BY ".$whereFIX." DESC LIMIT 1");
											while ($row = $sql->fetch_assoc()) {
												$neusterUser = $row['Name'];
											}
											echo "Das wir insgesamt <b>".number_format($mySQLcon->query("SELECT * FROM players")->num_rows,0,"",".")."</b> Registrierte Spieler haben, von denen <b>".number_format($mySQLcon->query("SELECT * FROM ban")->num_rows,0,"",".")."</b> gebannt sind?<br>Der neuste Spieler heißt <b>".$neusterUser."</b>";
											break;
										case 2:
											echo "Das alle Spieler insgesamt <b>".number_format($mySQLcon->query("SELECT * FROM vehicles")->num_rows,0,"",".")."</b> Fahrzeuge besitzen?";
											break;
										case 3:
											$hc = $mySQLcon->query("SELECT * FROM houses")->num_rows;
											echo "Das es <b>".number_format($hc,0,"",".")."</b> Häuser gibt, von denen <b>".number_format(($hc-($mySQLcon->query("SELECT * FROM houses WHERE ".((SCRIPT_TYPE=="ultimate") ? "UID='0'" : "Besitzer='none'"))->num_rows)),0,"",".")."</b> verkauft sind?";
											break;
										case 4:
											echo "Momentan wachsen <b>".number_format($mySQLcon->query("SELECT * FROM weed")->num_rows,0,"",".")."</b> Cannabispflanzen.";
											break;
										case 5:
											$army = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='8'")->num_rows;
											$sfpd = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='1'")->num_rows;
											$fbi = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='6'")->num_rows;
											
											$aztecas = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='7'")->num_rows;
											$biker = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='9'")->num_rows;
											$mafia = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='2'")->num_rows;
											$triaden = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='3'")->num_rows;
											$terror = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='4'")->num_rows;
											
											$ltr = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='5'")->num_rows;
											
											$gut = $army + $sfpd + $fbi;
											$boese = $aztecas + $biker + $mafia + $triaden + $terror;
											$neutral = $ltr;
											$frak = $gut + $boese + $neutral;
											
											echo "Das <b>".$frak."</b> Spieler in einer Fraktion sind? Davon <b>".$gut."</b> in einer Guten, <b>".$boese."</b> in einer Bösen und <b>".$neutral."</b> in einer Neutralen Fraktion.";
											break;
										case 6:
											$umlaufgeld = 0;
											
											$sql = $mySQLcon->query("SELECT * FROM userdata");
											while ($row = $sql->fetch_array()) {
												$umlaufgeld = $umlaufgeld + $row['Geld'];
												$umlaufgeld = $umlaufgeld + $row['Bankgeld'];
											}
											
											$sql = $mySQLcon->query("SELECT Kasse FROM biz");
											while ($row = $sql->fetch_array()) {
												$umlaufgeld = $umlaufgeld + $row['Kasse'];
											}
											
											$sql = $mySQLcon->query("SELECT Kasse FROM houses");
											while ($row = $sql->fetch_array()) {
												$umlaufgeld = $umlaufgeld + $row['Kasse'];
											}
											
											$sql = $mySQLcon->query("SELECT DepotGeld FROM fraktionen");
											while ($row = $sql->fetch_array()) {
												$umlaufgeld = $umlaufgeld + $row['DepotGeld'];
											}
											
											echo "Das <b>".number_format($umlaufgeld,0,"",".")." $</b> im Umlauf sind?";
											break;
									}	
								?>
							</div>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'home') ? 'active-menu' : '')?>" href="?page=home"><i class="fa fa-info-circle fa-3x"></i> Übersicht</a>
						</li>
						<?php if (USE_COINS) { ?><li>
							<a class="<?=(($_GET['page'] == 'coins') ? 'active-menu' : '')?>" href="?page=coins"><i class="fa fa-heart fa-3x"></i> Coins</a>
						</li><?php } ?>
						<li>
							<a class="<?=(($_GET['page'] == 'settings') ? 'active-menu' : '')?>" href="?page=settings"><i class="fa fa-cogs fa-3x"></i> Einstellungen</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'vehicles') ? 'active-menu' : '')?>" href="?page=vehicles"><i class="fa fa-truck fa-3x"></i> Fahrzeuge</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'faction') ? 'active-menu' : '')?>" href="?page=faction"><i class="fa fa-flag fa-3x"></i> Fraktion</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'inventory') ? 'active-menu' : '')?>" href="?page=inventory"><i class="fa fa-suitcase fa-3x"></i> Inventar / Waffenbox</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'house') ? 'active-menu' : '')?>" href="?page=house"><i class="fa fa-home fa-3x"></i> Haus</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'marktplatz') ? 'active-menu' : '')?>" href="?page=marktplatz"><i class="fa fa-shopping-cart fa-3x"></i> Marktplatz</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'rang') ? 'active-menu' : '')?>" href="?page=rang"><i class="fa fa-bar-chart-o fa-3x"></i> Ranglisten</a>
						</li>
						<li>
							<a class="<?=(($_GET['page'] == 'support') ? 'active-menu' : '')?>" href="?page=support"><i class="fa fa-question-circle fa-3x"></i> Support</a>
						</li>
						<?php if ($CP->Admin) { ?>
						<li>
							<a class="<?=((strpos($_GET['page'], 'admin-') !== false) ? 'active-menu' : '')?>" href="#"><i class="fa fa-users fa-3x"></i> Admin<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="?page=admin-players">Übersicht</a>
								</li>
								<li>
									<a href="?page=admin-checkplayer">Spieler Überprüfen</a>
								</li>
								<li>
									<a href="?page=admin-userdata">Spielerdaten bearbeiten</a>
								</li>
								<li>
									<a href="?page=admin-bans">Bans</a>
								</li>
								<li>
									<a class="<?=(($_GET['page'] == 'admin-support') ? 'active-menu' : '')?>" href="?page=admin-support"> Tickets</a>
								</li>
								<li>
									<a class="<?=(($_GET['page'] == 'admin-logs') ? 'active-menu' : '')?>" href="#">Logs<span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<?php
										$logs = ((SCRIPT_TYPE=='ultimate') ? $LogNamesUltimate : $LogNames);
										foreach ($logs as $i => $name) {
											echo '<li><a href="?page=admin-logs&log='.$i.'">'.$name.'</a></li>';
										}
										?>
									</ul>
								</li>
							</ul>
						</li>
						<?php } ?>
						<?php } else { ?>
						<li>
							<a class="<?=(($_GET['page'] == 'login') ? 'active-menu' : '')?>" href="?page=login"><i class="fa fa-edit fa-3x"></i> Login</a>
						</li>
						<?php } ?>
					</ul>
				</div>
			</nav>  
			<!-- /. NAV SIDE  -->
			
			<div id="page-wrapper" >
				<div id="page-inner">
					<div class="row">
						<div class="col-md-12">
							<h2><?=((!empty($pagetitles[$page])) ? $pagetitles[$page] : '404 Not Found')?></h2>   
						</div>
					</div>
					<hr />