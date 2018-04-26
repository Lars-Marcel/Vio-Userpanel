<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Spieler inGame
			</div>
			<div class="panel-body">
				<div id="AjaxResult"></div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Aktionen</th>
							</tr>
						</thead>
						<tbody id="playerList">
							
						</tbody>
					</table>
				</div>
				<br>
				<p>Spieler entbannen</p>
				<form role="form" onsubmit="return false;">
					<div class="form-group">
						<label>Spielername</label>
						<input class="form-control" type="text" id="nick" />
					</div>
					<button type="submit" class="btn btn-default" onclick="unban();">Entbannen</button>
				</form>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Screen
			</div>
			<div class="panel-body">
				<div id="AjaxResultScreen"></div>
				<img alt="" id="screen" width="100%" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Paysafe-Zahlungen
			</div>
			<div class="panel-body">
				<p>Folgende Paysafe-Zahlungen müssen noch bestätigt werden</p>
				<?php
				if (isset($_GET['act']) && $CP->Adminlvl >= 4) {
					if (isset($_POST['giveCoins'])) {
						$count = $_POST['count'];
						if (is_numeric($count)) {
							$sql = $mySQLcon->query("SELECT * FROM coins WHERE Name LIKE '".$mySQLcon->escape_string($_GET['act'])."'");
							$row = $sql->fetch_assoc();
							$newCoins = $row['Coins'] + $count;
							$mySQLcon->query("UPDATE coins SET Coins='$newCoins', psc='' WHERE Name LIKE '".$mySQLcon->escape_string($_GET['act'])."'");
							echo '<div class="alert alert-info">Coins erfolgreich gutgeschrieben.</div>';
							$log = @file_get_contents("logs/coins.log");
							file_put_contents("logs/coins.log", $log."[".date("d-m-Y, H:i:s")."]: (GIVE ".$count." Coins) Coin-Gutschrift PSC (Admin: ".$CP->Name." Spieler: ".$_GET['act'].")\n");
						} else {
							echo '<div class="alert alert-danger"><b>Bitte gib eine gültige Anzahl ein. <a href="#" onclick="window.reload();">Zurück</a></b></div>';
						}
					} else {
						echo '<form method="post" action="?page=admin-players&act='.$_GET['act'].'">
							Coin Anzahl (Wert der PIN geteilt durch '.COIN_WERT.'):<br>
							<input type="text" name="count">
							<input type="submit" name="giveCoins" value="Gutschreiben und PIN entfernen">
						</form>';
					}
				} else {
				?>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>PIN</th>
								<th>PSC-API*</th>
								<th>Aktion</th>
							</tr>
						</thead>
						<tbody id="playerList">
							<?php
							if ($CP->Adminlvl >= 4) {
								$sql = $mySQLcon->query("SELECT * FROM coins");
								while ($row = $sql->fetch_array()) {
									$pin = $row['psc'];
									if (!empty($pin)) {
										$apiShit = "";
										$pscCheck = checkPaysafecardPIN($pin);
										
										if ($pscCheck['success'] == true || ($pscCheck['success'] != true && $pscCheck['errorCode'] == 20008)) {
											$apiShit .= "PSC benutzt: ".(($pscCheck['used']== true) ? 'Ja' : 'Nein')."<br>Kaufdatum: ".((!empty($pscCheck['activationTimestamp'])) ? $pscCheck['activationTimestamp'] : '?')."<br>Wert: ".((!empty($pscCheck['faceValue'])) ? $pscCheck['faceValue'] : '?')." ".((!empty($pscCheck['currencyCode'])) ? $pscCheck['currencyCode'] : '')."<br>Aktuelles Guthaben: ".((is_numeric($pscCheck['availableBalance'])) ? $pscCheck['availableBalance'] : '?')." ".((!empty($pscCheck['currencyCode'])) ? $pscCheck['currencyCode'] : '');
										} else {
											$apiShit .= "Fehler bei der Abfrage (".$pscCheck['errorCode']." - ".$pscCheck['errorMsg'].").";
										}
										
										
										echo '<tr>
											<td>'.$row['Name'].'</td>
											<td>'.$pin.'</td>
											<td>'.$apiShit.'</td>
											<td><a href="?page=admin-players&act='.$row['Name'].'">Auswählen</a></td>
										</tr>';
									}
								}
							} else {
								echo '<div class="alert alert-danger"><b>Du brauchst mindestens Adminlevel 4.</b></div>';
							}
							?>
						</tbody>
					</table>
					<small>* Die Werte <i>Kaufdatum</i>,<i> Wert </i>und<i> aktuelles Guthaben</i> werden nur angezeigt, wenn die Paysafecard bereits verwendet wurde.</small>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Massenaktionen
			</div>
			<div class="panel-body">
				<?php
				if (isset($_POST['maction'])) {
					if ($CP->Adminlvl >= 4) {
						switch ($_POST['action']) {
							case 'bans':
								$mySQLcon->query("TRUNCATE ban");
							break;
							case 'warns':
								$mySQLcon->query("TRUNCATE warns");
								$mySQLcon->query("UPDATE userdata SET Warns='0'");
							break;
							case 'tickets':
								$mySQLcon->query("TRUNCATE support");
							break;
							case 'closedTickets':
								$mySQLcon->query("DELETE FROM support WHERE state='closed'");
							break;
							case 'kickFaction':
								$mySQLcon->query("UPDATE userdata SET Fraktion='0', FraktionsRang='0'");
							break;
						}
						echo '<div class="alert alert-info">Aktion ausgeführt.</div>';
					} else {
						echo '<div class="alert alert-error">Du benötigst mindestens Adminlevel 4.</div>';
					}
				}
				?>
				<form method="post" action="?page=admin-players">
					<div class="form-group">
						<label>Aktion</label>
						<select name="action" class="form-control">
							<option value="bans">Alle Spieler entbannen</option>
							<option value="warns">Alle Warns löschen</option>
							<option value="tickets">Alle Tickets löschen</option>
							<option value="closedTickets">Geschlossene Tickets löschen</option>
							<option value="kickFaction">Alle Spieler aus den Fraktionen werfen</option>
						</select>
					</div>
					<button type="submit" class="btn btn-default" name="maction">Aktion Ausführen</button>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Multi Accounts
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th>Account-Namen</th>
							<th>Serial</th>
						</tr>
					</thead>
					<tbody id="playerList">
						<?php
						$serialArr = array();
						$doubleSerialArr = array();
						
						$sql = $mySQLcon->query("SELECT * FROM players");
						while ($row = $sql->fetch_array()) {
							if (in_array($row['Serial'], $serialArr)) {
								array_push($doubleSerialArr, $row['Serial']);
							} else {
								array_push($serialArr, $row['Serial']);
							}
						}
						
						foreach ($doubleSerialArr as $serial) {
							$names = "";
							
							$sql = $mySQLcon->query("SELECT * FROM players WHERE Serial='".$serial."'");
							while ($row = $sql->fetch_array()) {
								$names .= $row['Name'].", ";
							}
							
							echo '<tr>
								<td>'.substr($names, 0, -2).'</td>
								<td>'.$serial.'</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	function refresh() {
		$.get("ajax/admin.php?action=playerlist", function(data) {
			var data = data.substr(0, data.length-1);
			var out = "";
			var players = data.split("|");
			for (i = 0; i < players.length; i++) {
				var pname = players[i];
				if (pname != "") {
					var fix = "<a href=\"#\" onclick=\"callAdminAJAX('kick', '"+pname+"');\">Kicken</a><br><a href=\"#\" onclick=\"callAdminAJAX('timeban', '"+pname+"');\">Timeban</a><br><a href=\"#\" onclick=\"callAdminAJAX('permaban', '"+pname+"');\">Permanenter Ban</a><br><a href=\"#\" onclick=\"takeScreen('"+pname+"');\">Screenshot</a>";
					out += '<tr><td>'+pname+'</td><td>'+fix+'</td></tr>';
				}
			}
			$("#playerList").html(out);
		});
		setTimeout(function(){ refresh(); }, 5000);
	}
	
	function callAdminAJAX(action, playername) {
		reason = "";
		time = "";
		if (action == "kick" || action == "permaban" || action == "timeban") {
			reason = prompt("Grund: ", "");
			if (!reason || reason == "") {
				alert('Du musst einen Grund angeben.');
				return false;
			}
		}
		if (action == "timeban") {
			time = prompt("Ban Zeit in Dezimal (0.01 = 1 Minute): ", "");
			if (!time || time == "") {
				alert('Du musst eine Zeit angeben.');
				return false;
			}
		}
		$.get("ajax/admin.php?action="+action+"&player="+playername+"&reason="+reason+"&time="+time, function(data) {
			$("#AjaxResult").html('<div class="alert alert-info">'+data+'</div>');
		});
		
		refresh();
	}
	
	function unban() {
		var nick = $('#nick').val();
		if (!nick || nick == "") { return alert('Du musst den Namen des Spielers angeben.'); }
		return callAdminAJAX('unban', nick);
	}
	
	function takeScreen(nick) {
		$("#screen").attr("src", "");
		$("#AjaxResultScreen").html('');
		$.get("ajax/admin.php?action=screen&player="+nick, function(data) {
			$("#AjaxResultScreen").html('<div class="alert alert-info">'+data+'</div>');
			if (data == "Einen moment...") {
				var nr = 0;
				
				var check = function() {
					var nr = nr + 1;
					
					$.get("ajax/admin.php?action=screen-result", function(data) {
						if (data != "") {
							var res = data.split("|");
							if (res[0] == "err") {
								$("#AjaxResultScreen").html('<div class="alert alert-info">'+res[1]+'</div>');
								nr = 0;
								return false;
							} else if (res[0] == "img") {
								$("#AjaxResultScreen").html('');
								$("#screen").attr("src", "data:image/jpeg;base64,"+res[1]);
								nr = 0;
								return true;
							}
						}
						
						if (nr <= 3) {
							setTimeout(function(){ check(); }, 3333);
						} else {
							$("#AjaxResultScreen").html('<div class="alert alert-error">Es konnte kein Screenshot erstellt werden.</div>');
							nr = 0;
						}
					});
				}
				setTimeout(function(){ check(); }, 3333);
				
			}
		});
	}
	
	refresh();
</script>