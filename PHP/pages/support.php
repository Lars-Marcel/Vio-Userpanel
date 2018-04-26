<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tickets
			</div>
			<div class="panel-body">
				<p>Deine Tickets: (Klick auf eine Spalte um das Ticket anzusehen.)</p>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Betreff</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = $mySQLcon->query("SELECT * FROM support WHERE player='".$mySQLcon->escape_string($CP->Name)."'");
							while ($row = $sql->fetch_assoc()) {
								echo "<tr onclick=\"location.href='?page=support&tID=".$row['ID']."';\">
								<td>".$row['ID']."</td>
								<td>".$row['subject']."</td>
								<td>".(($row['state'] == "open") ? "Geöffnet" : "Geschlossen")."</td>
								</tr>\n";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Ticket <?=((isset($_GET['tID']) && !empty($_GET['tID'])) ? '#'.$_GET['tID'] : '')?>
			</div>
			<div class="panel-body">
				<?php
				if (isset($_POST['replybtn']) && isset($_GET['tID']) && !empty($_GET['tID'])) {
					if (strlen($_POST['reply']) >= 3) {
						$sql = $mySQLcon->query("SELECT * FROM support WHERE ID='".$mySQLcon->escape_string($_GET['tID'])."'");
						if ($sql->num_rows > 0) {
							$row = $sql->fetch_assoc();
							
							if ($row['state'] == "open") {
								$newMsg = "Spieler ".$CP->Name." [".date("d-m-Y, H:i:s")."]:\n".$_POST['reply']."\n\n-----------------\n\n".$row['message'];
								$mySQLcon->query("UPDATE support SET message='".$mySQLcon->escape_string(strip_tags($newMsg))."' WHERE ID='".$mySQLcon->escape_string($_GET['tID'])."'");
								
								echo '<div class="alert alert-info">Antwort abgesendet.</div>';
								
								ob_start();
								$mtaServer = new mta(MTA_IP, MTA_HTTP_PORT, MTA_USER, MTA_PASS);
								$resource = $mtaServer->getResource(MTA_RESOURCE_NAME);
								$action = $resource->call("sendMsgToAdmins", $CP->Name." hat eine Antwort auf sein Ticket (#".$_GET['tID']." verfasst!");
								ob_end_clean();
							}
						}
					} else {
						echo '<div class="alert alert-danger"><b>Du musst eine Antwort eingeben.</b></div>';
					}
				}
				
				if (isset($_GET['tID']) && !empty($_GET['tID'])) {
					$sql = $mySQLcon->query("SELECT * FROM support WHERE ID='".$mySQLcon->escape_string($_GET['tID'])."'");
					if ($sql->num_rows > 0) {
						$row = $sql->fetch_assoc();
						if ($row['player'] == $CP->Name) {
							$fix = "";
							if ($row['state'] == "open") {
								$fix = '<br>
									<div class="form-group">
										<label>Antwort</label>
										<textarea class="form-control" rows="4" cols="50" name="reply"></textarea>
									</div>
									<button type="submit" class="btn btn-default" name="replybtn">Antworten</button>';
							}
							
							echo '<form role="form" method="post" action="?page=support&tID='.$_GET['tID'].'">
								<div class="form-group">
									<label>Betreff: '.strip_tags($row['subject']).'</label>
								</div>
								<div class="form-group">
									<label>Ticket-Verlauf</label>
									<textarea class="form-control" rows="4" cols="50" readonly="readonly">'.$row['message'].'</textarea>
								</div>
								'.$fix.'
							</form>';
						} else {
							echo '<p>Keine Berechtigung.</p>';
						}
					} else {
						echo '<p>Dieses Ticket existiert nicht.</p>';
					}
				} else {
					echo '<p>Wähle links ein Ticket aus.</p>';
				}
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Ticket erstellen
			</div>
			<div class="panel-body">
				<?php
				if (isset($_POST['newticket'])) {
					if (strlen($_POST['subject']) >= 5) {
						if (strlen($_POST['text']) >= 15) {
							$msg = "Spieler ".$CP->Name." [".date("d-m-Y, H:i:s")."]:\n".$_POST['text']."\n\n-----------------\n\n";
							$mySQLcon->query("INSERT INTO support (player, subject, message, state) VALUES ('".$mySQLcon->escape_string($CP->Name)."', '".$mySQLcon->escape_string(strip_tags($_POST['subject']))."', '".$mySQLcon->escape_string($msg)."', 'open')");
							echo '<div class="alert alert-info">Ticket erfolgreich erstellt (ID '.$mySQLcon->insert_id.').</div>';
							ob_start();
							$mtaServer = new mta(MTA_IP, MTA_HTTP_PORT, MTA_USER, MTA_PASS);
							$resource = $mtaServer->getResource(MTA_RESOURCE_NAME);
							$action = $resource->call("sendMsgToAdmins", $CP->Name." benötigt Hilfe!");
							ob_end_clean();
						} else {
							echo '<div class="alert alert-danger"><b>Du musst einen Text angeben.</b></div>';
						}
					} else {
						echo '<div class="alert alert-danger"><b>Du musst einen Betreff angeben.</b></div>';
					}
				}
				?>
				<form role="form" method="post" action="?page=support">
					<div class="form-group">
						<label>Betreff</label>
						<input class="form-control" type="text" name="subject" />
					</div>
					<div class="form-group">
						<label>Anliegen</label>
						<textarea class="form-control" rows="4" cols="50" name="text"></textarea>
					</div>
					<button type="submit" class="btn btn-default" name="newticket">Absenden</button>
				</form>
			</div>
		</div>
	</div>
</div>