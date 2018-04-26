<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

ob_start();
include("cfg.php");

if (DEBUG) {
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors', 1);
}

header("Cache-Control: no-cache");

$CP = new CP($mySQLcon);

if (!isset($_GET['page']) || empty($_GET['page'])) {
	if ($CP->Loggedin) {
		header("Location: ?page=home");
	} else {
		header("Location: ?page=login");
	}
	exit();
}

include("templates/header.php");

if (!$mySQLcon->connect_errno) {
	$r1 = substr(decoct(fileperms("index.php")), -3);
	$r2	= substr(decoct(fileperms("cronjob.php")), -3);
	$r3 = substr(decoct(fileperms("paypal/ipn.php")), -3);
	if (($r1 == 777 || $r1 == 755) && ($r2 == 777 || $r2 == 755) && ($r3 == 777 || $r3 == 755)) {
		$page = false;
		$intern = true;
		
		if (isset($_GET['page']) && !empty($_GET['page'])) {
			if (file_exists('pages/'.$_GET["page"].'.php')) {
				$page = $_GET["page"];
			}
		}
		
		if ((strpos($_GET['page'], 'admin') !== false && $CP->Admin == false) || (strpos($_GET['page'], '..') !== false)) {
			$page = "403";
		}
		
		if ($page != false) {
			if ($CP->Banned != false && in_array($_GET['page'], $bannedAllowedPages) == false) {
				$page = "banned";
			}
		} else {
			$page = "404";
		}
		
		include("pages/".$page.".php");
		
		if ($intern == true && $CP->Loggedin == false) {
			header("Location: ?page=login");
			exit;
		}
		$mySQLcon->close();
	} else {
		echo '<div class="alert alert-danger"><b>Ein Fehler ist aufgetreten.<br>Bitte wende dich an einen Administrator.</b><br><br>Die Dateien cronjob.php, index.php und paypal/ipn.php benötigen Schreibrechte (CHMOD 755).</div>';
	}
} else {
	echo '<div class="alert alert-danger"><b>Es konnte keine Verbindung zur Datenbank hergestellt werden.<br>Bitte wende dich an einen Administrator.</b><br><br>MySQL Fehlermeldung: '.$mySQLcon->connect_error.' (#'.$mySQLcon->connect_errno.')</div>';
}

include("templates/footer.php");

ob_end_flush();
?>