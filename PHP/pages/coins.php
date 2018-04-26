<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

if (!USE_COINS) {
	header("Location: ?page=home");
	exit;
}
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Was sind Coins, und was kann ich damit anfangen?
			</div>
			<div class="panel-body">
				<p>
					Du kanst dir Coins für Echtgeld kaufen und diese dann gegen verschiedene Sachen eintauschen. Dazu zählen:<br>
					<ul>
						<li>Änderung der Telefonnummer</li>
						<li>Änderung des Namens</li>
						<li>Premium Fahrzeuge</li>
						<li>Eigener Text im Status</li>
						<?php if (COINS_SELL_SKINS) { ?>
						<li>Skins kaufen</li>
						<?php } ?>
						<?php if (COINS_SELL_PREMIUM) { ?>
						<li>Premium Mitgliedschaft</li>
						<?php } ?>
						<?php if (COINS_SELL_MONEY) { ?>
						<li>inGame-Geld Kaufen</li>
						<?php } ?>
					</ul>
					<br>
					Ein Coin hat einen Wert von <?=COIN_WERT?> Euro.
					<br>
					<br>
					<b>Du hast <?=$CP->Coins?> Coins.</b>
				</p>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Coins Kaufen
			</div>
			<div class="panel-body">
				<?php
				if (isset($_GET['act']) && $_GET['act']) {
					switch ($_GET['act']) {
						case 'success':
							echo '<div class="alert alert-info">Zahlung erfolgreich.<br>Du hast nun '.$CP->Coins.' Coins.<br><b>Vielen Dank!</b></div>';
							break;
						case 'cancel':
							echo '<div class="alert alert-danger"><b>Bei deiner Zahlung ist ein Fehler aufgetreten.<br>Wende dich an einen Admin.</b></div>';
							break;
					}
				}
				if (isset($_POST['psc_buy'])) {
					if (preg_match('/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/', $_POST['pin']) && strlen($_POST['pin']) == 19) {
						$sql = $mySQLcon->query("SELECT * FROM coins WHERE Name='".$mySQLcon->escape_string($CP->Name)."'");
						if ($sql->num_rows > 0) {
							$row = $sql->fetch_assoc();
							if ($row['psc'] == "") {
								$pscCheck = checkPaysafecardPIN($_POST['pin']);
								if ($pscCheck['success'] == false) {
									echo '<div class="alert alert-danger"><b>Es ist ein Fehler aufgetreten: '.$pscCheck['errorMsg'].'</b></div>';
								} else {
									if ($pscCheck['used'] == false || ($pscCheck['used'] == true && $pscCheck['availableBalance'] > 0)) {
										$mySQLcon->query("UPDATE coins SET psc='".$mySQLcon->escape_string($_POST['pin'])."' WHERE Name='".$mySQLcon->escape_string($CP->Name)."'");
										echo '<div class="alert alert-info">Vielen Dank!<br>Bitte habe nun etwas geduld bis dein Antrag bearbeitet wurde.</div>';
									} else {
										echo '<div class="alert alert-danger"><b>Deine Paysafecard hat kein Guthaben mehr.</b></div>';
									}
								}
							} else {
								echo '<div class="alert alert-danger"><b>Ein Auftrag von dir ist derzeit noch in Bearbeitung.</b></div>';
							}
							
							ob_start();
							$mtaServer = new mta(MTA_IP, MTA_HTTP_PORT, MTA_USER, MTA_PASS);
							$resource = $mtaServer->getResource(MTA_RESOURCE_NAME);
							$action = $resource->call("sendMsgToAdmins", $CP->Name." bittet um Bestätigung seiner Paysafecard-Zahlung.");
							ob_end_clean();
						} else {
							$mySQLcon->query("INSERT INTO coins (Name, Coins, txn, psc) VALUES ('".$CP->Name."', '0', '', '".$mySQLcon->escape_string($_POST['pin'])."')");
							echo '<div class="alert alert-info">Vielen Dank!<br>Bitte habe nun etwas geduld bis dein Antrag bearbeitet wurde.</div>';
						}
					} else {
						echo '<div class="alert alert-danger"><b>Diese PIN ist ungültig.</b></div>';
					}
				}
				
				
				$fix = "";
				if (COINS_USE_PAYPAL) {
					$fix .= "PayPal";
				}
				if (COINS_USE_PAYSAFE) {
					if ($fix != "") { $fix .= " oder "; }
					$fix .= "Paysafecard (Manuelle bestätigung durch einen Admin erforderlich)";
				}
				?>
				<p>Du hast die möglichkeit die Coins via <?=$fix?> zu erwerben.</p>
				<br>
				<div class="form-group">
					<label>Anzahl Coins</label>
					<input class="form-control" type="text" id="coinAnzahl" />
					<p align="right">Summe: <span id="price">0.00</span> Euro.</p>
				</div>
				<br>
				<center>
					<?php
					if (COINS_USE_PAYPAL) {
						$pu = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
						echo '<div id="" style="float:left; width:40%;">
							<form action="https://www'.((PAYPAL_USE_SANDBOX == true) ? '.sandbox' : '').'.paypal.com/cgi-bin/webscr" method="post">
								<img src="https://www.paypalobjects.com/webstatic/de_DE/i/de-pp-logo-200px.png" alt="PayPal">
								<br>
								<br>
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="business" value="'.PAYPAL_EMAIL.'">
								
								<input type="hidden" name="item_name" value="Coins">
								
								<input type="hidden" name="lc" value="DE">
								<input type="hidden" name="currency_code" value="EUR">
								<input type="hidden" name="amount" value="'.COIN_WERT.'">
								<input type="hidden" name="quantity" value="0" id="paypalCoinAnzahl">
								
								<input type="hidden" name="no_shipping" value="1">
								<input type="hidden" name="no_note" value="0">
								<input type="hidden" name="cn" value="Nachricht an den Verkäufer: ">
								
								<input type="hidden" name="custom" value="'.$CP->Name.'">
								
								<input type="hidden" name="notify_url" value="http://'.$pu['host'].$pu['path'].'paypal/ipn.php">
								<input type="hidden" name="return" value="http://'.$pu['host'].$pu['path'].'?page=coins&act=success"> 
								<input type="hidden" name="cancel_return" value="http://'.$pu['host'].$pu['path'].'?page=coins&act=cancel"> 
								
								<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
								<input type="image" src="https://www.paypalobjects.com/de_DE/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
								<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
							</form>
						</div>';
					}
					if (COINS_USE_PAYSAFE) {
						if (COINS_USE_PAYPAL == true) { echo "oder"; }
						echo '<div id="" style="float:right; width:40%;">
							<form action="?page=coins" method="post">
								<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Paysafecard_logo.svg/1024px-Paysafecard_logo.svg.png" alt="Paysafecard">
								<br>
								<div class="form-group">
									<label>Paysafecard-PIN</label>
									<input class="form-control" type="text" name="pin" placeholder="XXXX-XXXX-XXXX-XXXX" />
								</div>
								<button type="submit" class="btn btn-default" name="psc_buy">Jetzt zahlungspflichtig Kaufen!</button>
							</form>
						</div>';
					}
					?>
				</center>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Aktionen
			</div>
			<div class="panel-body">
				<?php
				$back = true;
				$act = ((empty($_GET['act'])) ? "" : $_GET['act']);
				switch ($act) {
					case 'tel':
						if (isset($_POST['changeTel'])) {
							$len = strlen($_POST['newTel']);
							if ($len >= 3 && $len <= 20 && is_numeric($_POST['newTel']) && ($_POST['newTel'] != "110" && $_POST['newTel'] != "911" && $_POST['newTel'] != "666666" && $_POST['newTel'] != "333" && $_POST['newTel'] != "400")) {
								$price = 0;
								switch ($len) {
									case ($len >= 9 && $len <= 12):
										$price = 1;
										break;
									case ($len >= 6 && $len <= 8):
										$price = 2;
										break;
									case ($len >= 3 && $len <= 5):
										$price = 3;
										break;
								}
								if ($CP->Coins >= $price) {
									$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Telefonnr='".$mySQLcon->escape_string($_POST['newTel'])."'");
									if ($sql->num_rows == 0) {
										if ($CP->inGameLoggedin == false) {
											$mySQLcon->query("UPDATE userdata SET Telefonnr='".$mySQLcon->escape_string($_POST['newTel'])."' WHERE Name LIKE '".$mySQLcon->escape_string($CP->Name)."'");
											echo '<div class="alert alert-info">Deine Telefonnummer wurde erfolgreich geändert.</div>';
											$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Änderung der Telefonnummer (".$_POST['newTel'].")");
										} else {
											echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein um deine Telefonnummer zu ändern.</b></div>';
										}
									} else {
										echo '<div class="alert alert-danger"><b>Diese Telefonnummer ist bereits vergeben.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							} else {
								echo '<div class="alert alert-danger"><b>Diese Telefonnummer ist ungültig.</b></div>';
							}
						}
						echo '<p>Deine neue Telefonnummer muss zwischen 3 und 12 Zeichen haben.<br><br>
						Kosten der Änderung:<br>
						<ul>
							<li>9-12 Zeichen: 1 Coin</li>
							<li>6-8 Zeichen: 2 Coins</li>
							<li>3-5 Zeichen: 3 Coins</li>
						</ul>
						<br>
						<form role="form" method="post" action="?page=coins&act=tel">
							<div class="form-group">
								<label>Neue Telefonnummer</label>
								<input class="form-control" type="text" name="newTel" />
							</div>
							<button type="submit" class="btn btn-default" name="changeTel">Ändern</button>
						</form>';
						break;
					case 'nick':
						if (isset($_POST['changeNick'])) {
							$len = strlen($_POST['newNick']);
							$allowedChars = array("-", "_", "[", "]", "~", ".", "|", "!", "#", "@");
							$notAllowedNames = array("none", "admin", "mtasa", "mta");
							for ($i = 65; $i <= 90; $i++) {
								array_push($allowedChars, strtolower(chr($i)));
							}
							$okay = false;
							for ($i = 1; $i <= $len; $i++) {
								$chr = strtolower(substr($_POST['newNick'], $i, $i));
								if (in_array($chr, $allowedChars)) {
									$okay = true;
								} else if (is_numeric($chr)) {
									$okay = true;
								}
								if ($okay == false) { break; }
							}
							
							if ($okay == true && in_array($_POST['newNick'], $notAllowedNames) == false) {
								if ($len >= 3 && $len <= 20) {
									$price = 0;
									switch ($len) {
										case ($len >= 15 && $len <= 20):
											$price = 1;
											break;
										case ($len >= 10 && $len <= 14):
											$price = 2;
											break;
										case ($len >= 6 && $len <= 9):
											$price = 3;
											break;
										case ($len >= 3 && $len <= 5):
											$price = 4;
											break;
									}
									if ($CP->Coins >= $price) {
										$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Name LIKE '".$mySQLcon->escape_string($_POST['newNick'])."'");
										if ($sql->num_rows == 0) {
											if ($CP->inGameLoggedin == false) {
												$name = $CP->Name;
												if ($CP->changePlayerName($CP->Name, $_POST['newNick'])) {
													echo '<div class="alert alert-info">Du hast deinen Namen erfolgreich geändert.</div>';
													$CP->takePlayerCoins($price, "Spieler: ".$name." ; Änderung des Namens (".$_POST['newNick'].")");
												} else {
													echo '<div class="alert alert-danger"><b>Ein Fehler ist aufgetreten, bitte wende dich an einen Admin.</b></div>';
												}
											} else {
												echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein um deine Telefonnummer zu ändern.</b></div>';
											}
										} else {
											echo '<div class="alert alert-danger"><b>Dieser Name ist bereits vergeben.</b></div>';
										}
									} else {
										echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Der Name muss zwischen 3 und 20 Zeichen lang sein.</b></div>';
								}
							} else {
								echo '<div class="alert alert-danger"><b>Der Name enthält nicht erlaubte Zeichen.</b></div>';
							}
						}
						echo '<p>Dein neuer Name muss zwischen 3 und 20 Zeichen enthalten.<br><br>
						Kosten der Änderung:<br>
						<ul>
							<li>15-20 Zeichen: 1 Coin</li>
							<li>10-14 Zeichen: 2 Coins</li>
							<li>6-9 Zeichen: 3 Coins</li>
							<li>3-5 Zeichen: 4 Coins</li>
						</ul>
						<br>
						<form role="form" method="post" action="?page=coins&act=nick">
							<div class="form-group">
								<label>Neue Name</label>
								<input class="form-control" type="text" name="newNick" />
							</div>
							<button type="submit" class="btn btn-default" name="changeNick">Ändern</button>
						</form>';
						break;
					case 'state':
						if (isset($_POST['changeState'])) {
							$len = strlen($_POST['newState']);
							if ($len >= 3 && $len <= 30) {
								$price = 0;
								switch ($len) {
									case ($len >= 23 && $len <= 30):
										$price = 3;
										break;
									case ($len >= 13 && $len <= 22):
										$price = 2;
										break;
									case ($len >= 3 && $len <= 12):
										$price = 1;
										break;
								}
								if ($CP->Coins >= $price) {
									if ($CP->inGameLoggedin == false) {
										$mySQLcon->query("UPDATE userdata SET SocialState='".$mySQLcon->escape_string(strip_tags($_POST['newState']))."' WHERE Name LIKE '".$mySQLcon->escape_string($CP->Name)."'");
										echo '<div class="alert alert-info">Dein Status wurde erfolgreich geändert.</div>';
										$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Änderung des Status (".$_POST['newState'].")");
									} else {
										echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein um deinen Status zu ändern.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							} else {
								echo '<div class="alert alert-danger"><b>Dein Status muss zwischen 3 und 30 Zeichen lang sein.</b></div>';
							}
						}
						
						echo '<p>Dein neuer Status muss zwischen 3 und 30 Zeichen enthalten.<br><br>
						Kosten der Änderung:<br>
						<ul>
							<li>23-30 Zeichen: 3 Coins</li>
							<li>13-22 Zeichen: 2 Coins</li>
							<li>3-12 Zeichen: 1 Coin</li>
						</ul>
						<br>
						<form role="form" method="post" action="?page=coins&act=state">
							<div class="form-group">
								<label>Neuer Status</label>
								<input class="form-control" type="text" name="newState" />
							</div>
							<button type="submit" class="btn btn-default" name="changeState">Ändern</button>
						</form>';
						break;
					case 'cars':
						$whereFIX = "Besitzer LIKE '".$mySQLcon->escape_string($CP->Name)."'";
						if (SCRIPT_TYPE=='ultimate') {
							$whereFIX = "UID='".$mySQLcon->escape_string($CP->UID)."'";
						}
						
						if (isset($_POST['buyCar'])) {
							$car = $_POST['car'];
							$slot = $_POST['slot'];
							$price = $premiumCars[$car];
							
							if (!empty($price) && !empty($slot)) {
								if ($CP->Coins >= $price) {
									$mySQLcon->query("UPDATE vehicles SET Typ='".$mySQLcon->escape_string($car)."' WHERE ".$whereFIX." AND Slot='".$mySQLcon->escape_string($slot)."'");
									echo '<div class="alert alert-info">Fahrzeug erfolgreich gekauft. Du musst das Fahrzeug nun respawnen.</div>';
									$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Fahrzeugkauf (".$car.")");
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							}
						}
						
						$cars = "";
						$myCars = "";
						foreach ($premiumCars as $id => $price) {
							$cars .= '<option value="'.$id.'">'.$vehname[$id].' - '.$price.' Coin(s)</option>';
						}
						$sql = $mySQLcon->query("SELECT * FROM vehicles WHERE ".$whereFIX);
						while ($row = $sql->fetch_array()) {
							$myCars .= '<option value="'.$row['Slot'].'">Slot '.$row['Slot'].' - '.$vehname[$row['Typ']].'</option>';
						}
						
						echo '<p>Bitte wähle ein Fahrzeug aus der Liste aus.
						<br>
						<form method="post" action="?page=coins&act=cars">
							<div class="form-group">
								<label>Fahrzeug</label>
								<select name="car" class="form-control">
								'.$cars.'
								</select>
							</div>
							<div class="form-group">
								<label>Slot (Kauf dir einen Tampa)</label>
								<select name="slot" class="form-control">
								'.$myCars.'
								</select>
							</div>
							<button type="submit" class="btn btn-default" name="buyCar">Kaufen</button>
						</form>';
						break;
					case 'prem':
						if (!COINS_SELL_PREMIUM) { break; }
						if (SCRIPT_TYPE != 'ultimate') {
							$leftDays = $CP->LeftVIPDays;
							if (isset($_POST['buyPrem'])) {
								$days = $_POST['days'];
								$price = $premiumPrices[$days];
								if (is_numeric($price)) {
									if ($CP->Coins >= $price) {
										if ($CP->inGameLoggedin == false) {
											
											if ($days == "Lifetime") {
												$premYear = date("Y") + 99;
												$premDay = 1;
											} else {
												$premYear = date("Y");
												$premDay = (date("z")+1) + ($leftDays + $days);
												if ($premDay >= 365) {
													$premYear++;
													$premDay = $premDay-365;
												}
											}
											
											$whereFIX = "Name LIKE '".$mySQLcon->escape_string($CP->Name)."'";
											if (SCRIPT_TYPE=='ultimate') {
												$whereFIX = "UID='".$mySQLcon->escape_string($CP->UID)."'";
											}
											$mySQLcon->query("UPDATE bonustable SET PremiumUntilYear='".$mySQLcon->escape_string($premYear)."', PremiumUntilDay='".$mySQLcon->escape_string($premDay)."' WHERE ".$whereFIX);
											echo '<div class="alert alert-info">Deine Premium Mitgliedschaft wurde erfolgreich aktiviert.</div>';
											
											$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Premium (".$_POST['days'].")");
										} else {
											echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein um eine Premium Mitgliedschaft zu kaufen.</b></div>';
										}
									} else {
										echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
									}
								}
							}
							
							$PKGS = "";
							foreach ($premiumPrices as $k => $v) {
								$FIX = " Tage";
								if ($k == "Lifetime") { $FIX=""; }
								$PKGS .= '<div class="radio"><label><input type="radio" name="days" value="'.$k.'" />'.$k.$FIX.' für '.$v.' Coins</label></div>';
							}
							echo '<p>Eine Premium Mitgliedschaft bietet Dir folgende Vorteile:<br>
							<ul>
								<li>10 Carslots</li>
								<li>PMs gratis</li>
								<li>50% weniger Geldverlust beim Tod</li>
								<li>Spawn mit Schlagring</li>
								<li>Freundesliste</li>
								<li>Premium Autohaus mit: Oceanic, Euros, Stuntflugzeug, Burrito, Phoenix, Sabre, Hotknife</li>
								<li>Die Punkte hier ggf. anpassen (siehe pages/coins.php, Zeile '.__LINE__.')</li>
							</ul>
							<br>
							<p>Du hast '.(($leftDays >= 1000) ? 'Lifetime' : 'noch <b>'.$leftDays.'</b> Tage').' Premium.</p>
							<br>
							<form method="post" action="?page=coins&act=prem">
								<div class="form-group">
									<label>Anzahl Tage</label>
									'.$PKGS.'
								</div>
								<button type="submit" class="btn btn-default" name="buyPrem">Kaufen</button>
							</form>';
							
						} else {
							$price = $premiumPrices["Lifetime"];
							
							if (isset($_POST['buyPrem'])) {
								if ($CP->Coins >= $price) {
									if ($CP->inGameLoggedin == false) {
										if ($CP->Adminlvl > 0) {
											echo '<div class="alert alert-danger"><b>Du hast bereits Premium.</b></div>';
										} else {
											$whereFIX = "Name LIKE '".$mySQLcon->escape_string($CP->Name)."'";
											if (SCRIPT_TYPE=='ultimate') {
												$whereFIX = "UID='".$mySQLcon->escape_string($CP->UID)."'";
											}
											$mySQLcon->query("UPDATE userdata SET Adminlevel='1' WHERE ".$whereFIX);
											echo '<div class="alert alert-info">Deine Premium Mitgliedschaft wurde erfolgreich aktiviert.</div>';
											
											$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Premium (Lifetime)");
										}
									} else {
										echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein um eine Premium Mitgliedschaft zu kaufen.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							}
							
							echo '<p>Eine Premium Mitgliedschaft bietet Dir folgende Vorteile:<br>
							<ul>
								<li>10 Carslots</li>
								<li>PMs gratis</li>
								<li>50% weniger Geldverlust beim Tod</li>
								<li>Spawn mit Schlagring</li>
								<li>Freundesliste</li>
								<li>Premium Autohaus mit: Oceanic, Euros, Stuntflugzeug, Burrito, Phoenix, Sabre, Hotknife</li>
								<li>Die Punkte hier ggf. anpassen (siehe pages/coins.php, Zeile '.__LINE__.')</li>
							</ul>
							<br>
							<p>Premium-Status: '.(($CP->Adminlvl > 0) ? 'Aktiv' : 'Inaktiv').'</p>
							<br>
							<form method="post" action="?page=coins&act=prem">
								<button type="submit" class="btn btn-default" name="buyPrem">Premium für '.$price.' Coins Kaufen</button>
							</form>';
						}
						break;
					case 'giveaway':
						if (!COINS_GIVE_AWAY) { break; }
						if (isset($_POST['give'])) {
							$pname = $_POST['pname'];
							$count = $_POST['count'];
							
							if (is_numeric($count) && $count > 0) {
								if ($CP->Coins >= $count) {
									$sql = $mySQLcon->query("SELECT * FROM coins WHERE Name LIKE '".$mySQLcon->escape_string($pname)."'");
									if ($sql->num_rows > 0 && strtolower($CP->Name) != strtolower($pname)) {
										$row = $sql->fetch_assoc();
										$newCount = $row['Coins'] + $count;
										$mySQLcon->query("UPDATE coins SET Coins='".$newCount."' WHERE Name LIKE '".$mySQLcon->escape_string($row['Name'])."'");
										
										$CP->takePlayerCoins($count, "Spieler: ".$CP->Name." ; Coin-Transfer (".$_POST['count']." an ".$pname.")");
										
										echo '<div class="alert alert-info">Du hast die Coins erfolgreich verschenkt.</div>';
									} else {
										echo '<div class="alert alert-danger"><b>Der angegebene Spieler wurde nicht gefunden.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							} else {
								echo '<div class="alert alert-danger"><b>Bitte gib eine gültige Anzahl an.</b></div>';
							}
						}
						
						echo '<p>Du hast die Möglichkeit, Coins an andere Spieler zu verschenken.<br>Gib dazu den Spielernamen und die Anzahl der Coins an.</p>
						<br>
						<form method="post" action="?page=coins&act=giveaway">
							<div class="form-group">
								<label>Spielername</label>
								<input class="form-control" type="text" name="pname" />
							</div>
							<div class="form-group">
								<label>Anzahl Coins</label>
								<input class="form-control" type="text" name="count" />
							</div>
							<button type="submit" class="btn btn-default" name="give">Coins verschenken</button>
						</form>';
						break;
					case 'money':
						if (!COINS_SELL_MONEY) { break; }
						if (isset($_POST['buyMoney'])) {
							$pkg = $_POST['pkg'];
							$price = $moneyPrices[$pkg];
							if (is_numeric($price)) {
								if ($CP->Coins >= $price) {
									if ($CP->inGameLoggedin == false) {
										
										$mySQLcon->query("UPDATE userdata SET Bankgeld=Bankgeld+'".$mySQLcon->escape_string($pkg)."' WHERE Name LIKE '".$mySQLcon->escape_string($CP->Name)."'");
										
										echo '<div class="alert alert-info">Das Geld wurde dir auf deinem Konto gutgeschrieben.</div>';
										
										$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Kauf von inGame-Geld (".$_POST['pkg'].")");
									} else {
										echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							}
						}
						
						$PKGS = "";
						foreach ($moneyPrices as $k => $v) {
							$PKGS .= '<div class="radio"><label><input type="radio" name="pkg" value="'.$k.'" />'.number_format($k,0,"",".").' $ - '.$v.' Coins</label></div>';
						}
						echo '<form method="post" action="?page=coins&act=money">
							<div class="form-group">
								<label>Pakete</label>
								'.$PKGS.'
							</div>
							<button type="submit" class="btn btn-default" name="buyMoney">Kaufen</button>
						</form>';
						break;
						
					case 'skins':
						if (!COINS_SELL_SKINS) { break; }
						if (isset($_POST['buySkin'])) {
							$skin = $_POST['skinid'];
							$price = $coinSkins[$skin];
							if (is_numeric($price)) {
								if ($CP->Coins >= $price) {
									if ($CP->inGameLoggedin == false) {
										
										$mySQLcon->query("UPDATE userdata SET Skinid='".$mySQLcon->escape_string($skin)."' WHERE Name LIKE '".$mySQLcon->escape_string($CP->Name)."'");
										
										echo '<div class="alert alert-info">Du hast den Skin erfolgreich gekauft.</div>';
										
										$CP->takePlayerCoins($price, "Spieler: ".$CP->Name." ; Skin-Kauf (".$skin.")");
									} else {
										echo '<div class="alert alert-danger"><b>Du musst inGame Offline sein.</b></div>';
									}
								} else {
									echo '<div class="alert alert-danger"><b>Du hast nicht genug Coins.</b></div>';
								}
							}
						}
						
						foreach ($coinSkins as $k => $v) {
							echo '<img style="cursor:pointer;" src="assets/img/skins/'.$k.'.png" alt="Skin #'.$k.' Preis: '.$v.' Coin(s)" title="Skin #'.$k.' Preis: '.$v.' Coin(s)" onclick="setSkin('.$k.', '.$v.');" />';
						}
						echo '<br><br><br><form id="buyskinform" method="post" action="?page=coins&act=skins">
							<div class="form-group">
								<label>Ausgewählter Skin: <span id="selectedSkin">Keiner</span></label>
								<input type="hidden" id="selectedSkinID" name="skinid" value="" />
								<br>
								<button type="submit" class="btn btn-default" name="buySkin">Kaufen</button>
							</div>
						</form>';
						
						break;
						
					default:
						echo '<p>
							<a href="?page=coins&act=tel">Telefonnummer ändern</a><br>
							<a href="?page=coins&act=nick">Namen ändern</a><br>
							<a href="?page=coins&act=state">Status ändern</a><br>
							<a href="?page=coins&act=cars">Premiumfahrzeug Kaufen</a>
							'.((COINS_SELL_SKINS) ? '<br><a href="?page=coins&act=skins">Skin Kaufen</a>' : '').'
							'.((COINS_SELL_PREMIUM) ? '<br><a href="?page=coins&act=prem">Premiummitgliedschaft kaufen</a>' : '').'
							'.((COINS_SELL_MONEY) ? '<br><a href="?page=coins&act=money">inGame-Geld Kaufen</a>' : '').'
							'.((COINS_GIVE_AWAY) ? '<br><a href="?page=coins&act=giveaway">Coins verschenken</a>' : '').'
						</p>';
						$back = false;
				}
				
				if ($back == true) {
					echo '<p align="right"><a href="?page=coins">Zurück</a></p>';
				}
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#coinAnzahl").keyup(function() {
			calc();
		});
	});
	function calc() {
		if (isNumber(jQuery("#coinAnzahl").val())) {
			var count = parseInt(jQuery("#coinAnzahl").val().replace(",","."));
			var price = count * <?=COIN_WERT?>;
			var price = (price).toFixed(2);
			jQuery("#price").html(price);
			jQuery("#paypalCoinAnzahl").val(count);
		} else {
			jQuery("#price").html("0.00");
			jQuery("#paypalCoinAnzahl").val("0");
		}
	}
	function isNumber(n) {
		return !isNaN(parseFloat(n)) && isFinite(n);
	}
	
	function setSkin(skin, coins) {
		$('#selectedSkin').html('Skin #'+skin+', Preis: '+coins+' Coin(s)');
		$('#selectedSkinID').val(skin);
		window.location.href = "#buyskinform";
	}
</script>