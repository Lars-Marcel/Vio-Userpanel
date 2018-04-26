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
				<p>Tickets: (Klick auf eine Spalte um das Ticket anzusehen.)</p>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Spieler</th>
								<th>Betreff</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset($_GET['tID']) && !empty($_GET['tID']) && isset($_GET['act']) && !empty($_GET['act'])) {
								$mySQLcon->query("UPDATE support SET state='".$mySQLcon->escape_string($_GET['act'])."' WHERE ID='".$mySQLcon->escape_string($_GET['tID'])."'");
							}
							
							$sql = $mySQLcon->query("SELECT * FROM support");
							while ($row = $sql->fetch_assoc()) {
								echo "<tr onclick=\"location.href='?page=admin-support&tID=".$row['ID']."';\">
								<td>".$row['ID']."</td>
								<td>".$row['player']."</td>
								<td>".strip_tags($row['subject'])."</td>
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
								$newMsg = "Admin ".$CP->Name." [".date("d-m-Y, H:i:s")."]:\n".$_POST['reply']."\n\n-----------------\n\n".$row['message'];
								$mySQLcon->query("UPDATE support SET message='".$mySQLcon->escape_string($newMsg)."' WHERE ID='".$mySQLcon->escape_string($_GET['tID'])."'");
								
								echo '<div class="alert alert-info">Antwort abgesendet.</div>';
								
								ob_start();
								$mtaServer = new mta(MTA_IP, MTA_HTTP_PORT, MTA_USER, MTA_PASS);
								$resource = $mtaServer->getResource(MTA_RESOURCE_NAME);
								$action = $resource->call("sendMsgToPlayer", $row['player'], "Du hast eine Antwort auf dein Ticket (".$_GET['tID'].") erhalten.");
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
						$fix = "";
						$act = "open";
						$actText = "Ticket Öffnen";
						if ($row['state'] == "open") {
							$act = "closed";
							$actText = "Ticket Schliessen";
							$fix = '<br>
							<div class="form-group">
								<label>Antwort:</label>
								<textarea class="form-control" rows="4" cols="50" name="reply"></textarea>
							</div>
							<button type="submit" class="btn btn-default" name="replybtn">Antworten</button>';
						}
						
						echo '<form role="form" method="post" action="?page=admin-support&tID='.$_GET['tID'].'">
							<div class="form-group">
								<label>Betreff: '.strip_tags($row['subject']).' (<a href="?page=admin-support&tID='.$_GET['tID'].'&act='.$act.'">'.$actText.'</a>)</label>
							</div>
							<div class="form-group">
								<label>Ticket-Verlauf:</label>
								<textarea class="form-control" rows="4" cols="50" readonly="readonly">'.$row['message'].'</textarea>
							</div>
							'.$fix.'
						</form>';
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
</div>