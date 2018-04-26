<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Passwort ändern
			</div>
			<div class="panel-body">
				<?php
				if (isset($_POST['pwchange']))  {
					if (!empty($_POST['pw1'])) {
						if (strlen($_POST['pw1']) >= 6) {
							if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,30}$/', $_POST['pw1'])) {
								if ($_POST['pw1'] == $_POST['pw2']) {
									
									$salz = uniqid();
									$gesalzen = "";
									if (SCRIPT_TYPE == "lite") {
										$gesalzen = strtoupper(hash('md5', $_POST['pw1']));
										$salz = false;
									} else if (SCRIPT_TYPE == "extended") {
										$gesalzen = strtoupper(hash('md5', $_POST['pw1'].$salz));
									} else if (SCRIPT_TYPE == "thc") {
										$gesalzen = strtoupper(hash('sha256', $_POST['pw1'].$salz));
									} else if (SCRIPT_TYPE == "ultimate") {
										$gesalzen = strtolower(hash('sha512', strtolower(hash('sha512', $_POST['pw1']))));
										$salz = false;
									}

									
									$FIX = "";
									if ($salz != false) { $FIX = ", Salt='$salz'"; }
									$mySQLcon->query("UPDATE players SET Passwort='$gesalzen'".$FIX." WHERE Name='".$mySQLcon->escape_string($CP->Name)."'");
									
									echo '<div class="alert alert-info">Dein Passwort wurde erfolgreich geändert.</div>';
								} else {
									echo '<div class="alert alert-danger"><b>Die Passwörter stimmen nicht überein.</b></div>';
								}
							} else {
								echo '<div class="alert alert-danger"><b>Dein Passwort muss mindestens 6 Zeichen lang sein, einen Klein- sowie Großbuchstaben und eine Zahl enthalten.</b></div>';
							}
						} else {
							echo '<div class="alert alert-danger"><b>Dein Passwort muss mindestens 6 Zeichen enthalten.</b></div>';
						}
					} else {
						echo '<div class="alert alert-danger"><b>Du hast kein Passwort angegeben.</b></div>';
					}
				}
				?>
				<p>
					Dein Passwort muss mindestens 6 Zeichen lang sein, einen Klein- sowie Großbuchstaben und eine Zahl enthalten.
				</p>
				<br>
				<form role="form" method="post" action="?page=settings">
					<div class="form-group">
						<label>Passwort</label>
						<input class="form-control" type="password" name="pw1" />
					</div>
					<div class="form-group">
						<label>Passwort (Wdh.)</label>
						<input class="form-control" type="password" name="pw2" />
					</div>
					<button type="submit" class="btn btn-default" name="pwchange">Passwort ändern</button>
				</form>
			</div>
		</div>
	</div>
	<?php if (USE_TS3_SYNCHRONISATION) { ?>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Teamspeak Freischaltung / Synchronisation
			</div>
			<div class="panel-body">
				<?php
				$fix = "";
				$sql = $mySQLcon->query("SELECT * FROM players WHERE Name='".$mySQLcon->escape_string($CP->Name)."'");
				$row = $sql->fetch_assoc();
				if (!empty($row['ts3uid'])) {
					$fix = "<br><br><b>Hinweis:</b> Du hast bereits eine UID freigeschaltet (".$row['ts3uid'].").<br>Falls Du nun eine neue Freischaltest wird Deine alte UID entfernt.";
				}
				
				if (isset($_POST['tsuid'])) {
					if (base64_decode($_POST['uid']) != false && strlen($_POST['uid']) >= 10) {
						
						try {
							TeamSpeak3::init();
							$ts3Con = TeamSpeak3::factory("serverquery://".$ts3Server["ts_query_admin"].":".$ts3Server["ts_query_password"]."@".$ts3Server["tsip"].":".$ts3Server["ts_query_port"]."/?server_port=".$ts3Server["tsport"]."&nickname=".$ts3Server["ts_query_user_nick"]."");
							
							$in = false;
							foreach ($ts3Con->clientList() as $client) {
								if ($client["client_unique_identifier"] == $_POST['uid']) {
									$in = true;
									break;
								}
							}
							
							if ($in == true) {
								$mySQLcon->query("UPDATE players SET ts3uid='".$mySQLcon->escape_string($_POST['uid'])."' WHERE Name='".$mySQLcon->escape_string($CP->Name)."'");
								echo '<div class="alert alert-info">Eindeutige ID erfolgreich eingetragen.</div>';
							} else {
								echo '<div class="alert alert-danger"><b>Deine UID ist dem Teamspeak-Server nicht bekannt, bitte verbinde dich mit dem Teamspeak-Server und versuche es erneut.</b></div>';
							}
						} catch(Exception $e) {
							echo '<div class="alert alert-danger"><b>Fehler #'.$e->getCode().', '.$e->getMessage().'</b></div>';
						}
						
					} else {
						echo '<div class="alert alert-danger"><b>Bitte gib eine gültige Teamspeak UID an.</b></div>';
					}
				}
				?>
				<p>
					Um den Teamspeak-Server in vollem Umfang nutzen zu können, musst Du deine Eindeutige ID (UID) Freischalten.
					<br>
					Deine UID findest Du in Teamspeak mit dem Tastenkürzel "STRG + I".<br>
					Zur Freischaltung musst Du dich auf dem Teamspeak Server befinden.<br>
					Nach eingabe der UID kann es etwa eine Minute dauern, bis die Änderungen eintreten.<br>
					Die Servergruppen werden dir automatisch zugewiesen.
					<?=$fix?>
				</p>
				<br>
				<form role="form" method="post" action="?page=settings">
					<div class="form-group">
						<label>Eindeutige ID</label>
						<input type="text" class="form-control" type="text" name="uid" />
					</div>
					<button type="submit" class="btn btn-default" name="tsuid">Freischalten</button>
				</form>
			</div>
		</div>
	</div>
	<?php } ?>
</div>