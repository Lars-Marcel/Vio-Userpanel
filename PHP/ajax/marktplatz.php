<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
include("../cfg.php");

$CP = new CP($mySQLcon);

$return = array("state" => true, "msg" => "", "data" => false);


if ($CP->Loggedin && isset($_GET['id'])) {
	
	if (isset($_GET['act']) && $_GET['act'] == "buy") {
		
		$sql = $mySQLcon->query("SELECT * FROM marktplatz WHERE ID='".$mySQLcon->escape_string($_GET['id'])."';");
		if ($sql->num_rows > 0) {
			$row = $sql->fetch_assoc();
			
			if ($CP->UserData['userdata']['Bankgeld'] >= $row['price']) {
				if ($row['buyer'] == "") {
					if ($CP->Name != $row['seller']) {
						if (strtotime($row['endtime']) >= time()) {
							
							$mySQLcon->query("UPDATE marktplatz SET buyer='".$mySQLcon->escape_string($CP->Name)."' WHERE ID='".$mySQLcon->escape_string($_GET['id'])."';");
							
							$return['msg'] = 'Du hast den Artikel gekauft! Wende dich zur Abwicklung des Kaufs an '.$row['seller'].'.';
							
						} else {
							$return['state'] = false;
							$return['msg'] = 'Das Angebot wurde bereits beendet.';
						}
					} else {
						$return['state'] = false;
						$return['msg'] = 'Du kannst dein eigenes Angebot nicht kaufen.';
					}
				} else {
					$return['state'] = false;
					$return['msg'] = 'Das Angebot wurde bereits verkauft.';
				}
			} else {
				$return['state'] = false;
				$return['msg'] = 'Du hast nicht genug Geld auf deinem Konto.';
			}
			
			
		}
		
		
	} else if (isset($_GET['act']) && $_GET['act'] == "del") {
		
		$sql = $mySQLcon->query("SELECT * FROM marktplatz WHERE ID='".$mySQLcon->escape_string($_GET['id'])."';");
		if ($sql->num_rows > 0) {
			$row = $sql->fetch_assoc();
			
			if ($row['seller'] == $CP->Name) {
				
				$mySQLcon->query("DELETE FROM marktplatz WHERE ID='".$mySQLcon->escape_string($_GET['id'])."';");
				
			} else {
				$return['state'] = false;
				$return['msg'] = 'N?, Freundchen! ;)';
			}
		}
		
	} else {
		
		$sql = $mySQLcon->query("SELECT * FROM marktplatz WHERE ID='".$mySQLcon->escape_string($_GET['id'])."';");
		if ($sql->num_rows > 0) {
			$row = $sql->fetch_assoc();
			if ($row['buyer'] == "") {
				if (strtotime($row['endtime']) >= time()) {
					
					$row['description'] = str_replace("\n", "<br>", $row['description']);
					$row['myOffer'] = (($row['seller'] == $CP->Name) ? true : false);
					$row['endtime'] = date("d.m.y, H:i:s", strtotime($row['endtime']));
					$return['data'] = $row;
					
				} else {
					$return['state'] = false;
					$return['msg'] = 'Das Angebot wurde bereits beendet.';
				}
			} else {
				$return['state'] = false;
				$return['msg'] = 'Der Artikel wurde bereits verkauft.';
			}
		}
	}
}


echo json_encode($return, true);
?>