<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

include("cfg.php");

$r = substr(decoct(fileperms(__FILE__)), -3);
if (($r == 777 || $r == 755) && $mySQLcon) {
	
	$LOG = file_get_contents("logs/cronjob.log");

	//if (true) {
		if (USE_TS3_SYNCHRONISATION == true) {
			
			$ts3Con = false;
			try {
				TeamSpeak3::init();
				$ts3Con = TeamSpeak3::factory("serverquery://".$ts3Server["ts_query_admin"].":".$ts3Server["ts_query_password"]."@".$ts3Server["tsip"].":".$ts3Server["ts_query_port"]."/?server_port=".$ts3Server["tsport"]."&nickname=".$ts3Server["ts_query_user_nick"]."");
			} catch(Exception $e) {
				$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: Verbindungsaufbau fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
			}
			
			if ($ts3Con) {
				$UIDS = array();
				
				$sql = $mySQLcon->query("SELECT * FROM players");
				while (($row = $sql->fetch_array())) {
					if (!empty($row['ts3uid'])) {
						array_push($UIDS, $row['ts3uid']);
						
						$ts3Client = $ts3Con->clientGetNameByUid($row['ts3uid']);
						if ($ts3Client) { // User befindet sich momentan auf dem TS
							
							$sqlUserData = $mySQLcon->query("SELECT * FROM userdata WHERE Name='".$row['Name']."'");
							$rowUserData = $sqlUserData->fetch_assoc();
							
							
							if (!empty($groupsToSync['activated'])) {
								$clientList = $ts3Con->serverGroupClientList($groupsToSync['activated']);
								
								// User der Gruppe hinzufügen, falls er noch nicht drin ist
								$isIn = false;
								foreach ($clientList as $ID => $dataArr) {
									if ($dataArr['cldbid'] == $ts3Client["cldbid"]) {
										$isIn = true;
										break;
									}
								}
								if ($isIn == false) {
									try {
										$ts3Con->serverGroupClientAdd($groupsToSync['activated'], $ts3Client["cldbid"]);
									} catch(Exception $e) {
										$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientAdd (ADD '".$row['Name']." (".$row['ts3uid'].")' TO activated(".$groupsToSync['activated'].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
									}
								}
							}
							
							if (!empty($groupsToSync['premium'])) {
								$clientList = $ts3Con->serverGroupClientList($groupsToSync['premium']);
								
								// User der Gruppe hinzufügen, falls er noch nicht drin ist
								$isIn = false;
								foreach ($clientList as $ID => $dataArr) {
									if ($dataArr['cldbid'] == $ts3Client["cldbid"]) {
										$isIn = true;
										break;
									}
								}
								
								$whereFIX = ((SCRIPT_TYPE=='ultimate') ? "UID='".$row['UID']."'" : "Name='".$row['Name']."'");
								$sqlX = $mySQLcon->query("SELECT * FROM bonustable WHERE ".$whereFIX);
								$rowX = $sqlX->fetch_assoc();
								$yearDay = date("z")+1;
								$year = date("Y");
								$premDay = $rowX['PremiumUntilDay'];
								$premYear = $rowX['PremiumUntilYear'];
								if ($premYear == 0) { $premYear = $year; } 
								$days = ($premYear-$year)*365+($premDay-$yearDay);
								$days = (($days > 0) ? $days : 0);
								if ($rowUserData['Adminlevel'] > 0) { $days = 999; }
								
								if ($days > 0) {
									if ($isIn == false) {
										try {
											$ts3Con->serverGroupClientAdd($groupsToSync['premium'], $ts3Client["cldbid"]);
										} catch(Exception $e) {
											$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientAdd (ADD '".$row['Name']." (".$row['ts3uid'].")' TO premium(".$groupsToSync['premium'].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
										}
									}
								} else {
									if ($isIn == true) {
										try {
											$ts3Con->serverGroupClientDel($groupsToSync['premium'], $ts3Client["cldbid"]);
										} catch(Exception $e) {
											$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientDel (DEL '".$row['Name']." (".$row['ts3uid'].")' FROM premium(".$groupsToSync['premium'].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
										}
									}
								}
							}
							
							
							if (!empty($groupsToSync["team-".($rowUserData['Adminlevel'])])) {
								$clientList = $ts3Con->serverGroupClientList($groupsToSync['team-'.($rowUserData['Adminlevel'])]);
								$isIn = false;
								foreach ($clientList as $ID => $dataArr) {
									if ($dataArr['cldbid'] == $ts3Client["cldbid"]) {
										$isIn = true;
										break;
									}
								}
								
								if ($rowUserData['Adminlevel'] > 0) {
									if ($isIn == false) {
										try {
											$ts3Con->serverGroupClientAdd($groupsToSync['team-'.($rowUserData['Adminlevel'])], $ts3Client["cldbid"]);
										} catch(Exception $e) {
											$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientAdd (ADD '".$row['Name']." (".$row['ts3uid'].")' TO team-".$rowUserData['Adminlevel']."(".$groupsToSync['team-'.($rowUserData['Adminlevel'])].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
										}
									}
								} else {
									if ($isIn == true) {
										try {
											$ts3Con->serverGroupClientDel($groupsToSync['team-'.($rowUserData['Adminlevel'])], $ts3Client["cldbid"]);
										} catch(Exception $e) {
											$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientDel (DEL '".$row['Name']." (".$row['ts3uid'].")' FROM team-".$rowUserData['Adminlevel']."(".$groupsToSync['team-'.($rowUserData['Adminlevel'])].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
										}
									}
								}
							}
							
							
							for ($i = 0; $i <= 99; $i++) {
								if (!empty($groupsToSync['faction-'.$i])) {
									$clientList = $ts3Con->serverGroupClientList($groupsToSync['faction-'.$i]);
									$isIn = false;
									foreach ($clientList as $ID => $dataArr) {
										if ($dataArr['cldbid'] == $ts3Client["cldbid"]) {
											$isIn = true;
											break;
										}
									}
									
									if ($i == $rowUserData['Fraktion']) {
										if ($isIn == false) {
											try {
												$ts3Con->serverGroupClientAdd($groupsToSync['faction-'.$i], $ts3Client["cldbid"]);
											} catch(Exception $e) {
												$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientAdd (ADD '".$row['Name']." (".$row['ts3uid'].")' TO faction-".$rowUserData['Fraktion']."(".$groupsToSync['faction-'.($rowUserData['Fraktion'])].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
											}
										}
									} else {
										if ($isIn == true) {
											try {
												$ts3Con->serverGroupClientDel($groupsToSync['faction-'.$i], $ts3Client["cldbid"]);
											} catch(Exception $e) {
												$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientDel (DEL '".$row['Name']." (".$row['ts3uid'].")' FROM faction-".$rowUserData['Fraktion']."(".$groupsToSync['team-'.($rowUserData['Fraktion'])].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
											}
										}
									}
									
									if (!empty($groupsToSync['leader'])) {
										$clientListLeader = $ts3Con->serverGroupClientList($groupsToSync['leader']);
										$isInLeader = false;
										foreach ($clientListLeader as $ID => $dataArr) {
											if ($dataArr['cldbid'] == $ts3Client["cldbid"]) {
												$isInLeader = true;
												break;
											}
										}
										if ($rowUserData['FraktionsRang'] == LEADER_RANG) {
											if ($isInLeader == false) {
												try {
													$ts3Con->serverGroupClientAdd($groupsToSync['leader'], $ts3Client["cldbid"]);
												} catch(Exception $e) {
													$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientAdd (ADD '".$row['Name']." (".$row['ts3uid'].")' TO leader(".$groupsToSync['leader'].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
												}
											}
										} else {
											if ($isInLeader == true) {
												try {
													$ts3Con->serverGroupClientDel($groupsToSync['leader'], $ts3Client["cldbid"]);
												} catch(Exception $e) {
													$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientDel (DEL '".$row['Name']." (".$row['ts3uid'].")' FROM leader(".$groupsToSync['leader'].")) Fehlgeschlagen. Fehler #".$e->getCode().", ".$e->getMessage()."\n";
												}
											}
										}
									}
								}
							}
							
							
						}
					}
				}
				
				
				// Freigeschaltet User entfernen, welche nicht mehr in der DB stehen
				if (!empty($groupsToSync['activated'])) {
					$clientList = $ts3Con->serverGroupClientList($groupsToSync['activated']);
					foreach ($clientList as $ID => $dataArr) {
						$uid = new TeamSpeak3_Helper_String($dataArr['client_unique_identifier']);
						$uid = $uid->toString();
						
						if (!in_array($uid, $UIDS)) {
							try {
								$ts3Con->serverGroupClientDel($groupsToSync['activated'], $dataArr['cldbid']);
							} catch(Exception $e) {
								$LOG .= "[".date('d-m-Y, H:i:s')."]: Teamspeak: serverGroupClientDel (DEL '(".$uid.")' FROM activated(".$groupsToSync['activated'].")) Fehlgeschlagen . Fehler #".$e->getCode().", ".$e->getMessage()."\n";
							}
						}
					}
				}
				
			}
		}
		
		file_put_contents("logs/cronjob.log", $LOG);
	//}
	
}
?>