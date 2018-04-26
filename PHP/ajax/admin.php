<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
include("../cfg.php");

$CP = new CP($mySQLcon);

if ($CP->Admin) {
	if (isset($_GET['action'])) {
		ob_start();
		$mtaServer = new mta(MTA_IP, MTA_HTTP_PORT, MTA_USER, MTA_PASS);
		$resource = $mtaServer->getResource(MTA_RESOURCE_NAME);
		
		if ($_GET['action'] == "kick") {
			$action = $resource->call("kickPlayerWeb", $CP->Name, $_GET['player'], $_GET['reason']);
		} else if ($_GET['action'] == "permaban") {
			if ($CP->Adminlvl >= 2) {
				$action = $resource->call("permaBanWeb", $CP->Name, $_GET['player'], $_GET['reason']);
			} else {
				die("Nicht genügend Rechte.");
			}
		} else if ($_GET['action'] == "timeban") {
			if ($CP->Adminlvl >= 2) {
				$action = $resource->call("timeBanWeb", $CP->Name, $_GET['player'], $_GET['time'], $_GET['reason']);
			} else {
				die("Nicht genügend Rechte.");
			}
		} else if ($_GET['action'] == "unban") {
			if ($CP->Adminlvl >= 3) {
				$action = $resource->call("unbanWeb", $CP->Name, $_GET['player']);
			} else {
				die("Nicht genügend Rechte.");
			}
		} else if ($_GET['action'] == "playerlist") {
			$action = $resource->call("listAllPlayers");
		} else if ($_GET['action'] == "screen") {
			$action = $resource->call("makePlayerScreenshot", $_GET['player']);
		} else if ($_GET['action'] == "screen-result") {
			$action = $resource->call("getScreenResult");
		}
		ob_end_clean();
				
		if ($action[0] == "true") {
			echo "Aktion erfolgreich ausgeführt.";
		} else {
			echo $action[0];
		}
	}
}
?>