<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Spieler
			</div>
			<div class="panel-body">
				<?php
				$sql = $mySQLcon->query("SELECT * FROM players WHERE Name LIKE '".$mySQLcon->escape_string($_POST['nick'])."'");
				if ($sql->num_rows > 0) {
					$players = $sql->fetch_assoc();
					$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Name LIKE '".$mySQLcon->escape_string($_POST['nick'])."'");
					$userdata = $sql->fetch_assoc();
				?>
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td><b>Name:</b></td>
								<td><?=$players['Name']?></td>
							</tr>
							<tr>
								<td><b>User-ID:</b></td>
								<td><?=((!empty($players['id'])) ? $players['id'] : $players['UID'])?></td>
							</tr>
							<tr>
								<td><b>Registrierungsdatum:</b></td>
								<td><?=$players['RegisterDatum']?></td>
							</tr>
							<tr>
								<td><b>Letzter Login:</b></td>
								<td><?=$players['Last_login']?></td>
							</tr>
							<tr>
								<td><b>Serial:</b></td>
								<td><?=$players['Serial']?></td>
							</tr>
							<tr>
								<td><b>IP-Adresse:</b></td>
								<td><?=$players['IP']?></td>
							</tr>
							<tr>
								<td><b>Geburtsdatum:</b></td>
								<td><?=$players['Geburtsdatum_Tag']?>.<?=$players['Geburtsdatum_Monat']?>.<?=$players['Geburtsdatum_Jahr']?></td>
							</tr>
							<tr>
								<td><b>Geschlecht:</b></td>
								<td><?=(($players['Geschlecht'] == "0") ? "Männlich" : "Weiblich")?></td>
							</tr>
							<tr>
								<td><b>Geld:</b></td>
								<td><?=number_format($userdata['Geld'],0,"",".")?> $ (Hand), <?=number_format($userdata['Bankgeld'],0,"",".")?> $ (Bank)</td>
							</tr>
							<tr>
								<td><b>Spielzeit:</b></td>
								<td><?=floor($userdata['Spielzeit']/60).":".($userdata['Spielzeit']%60)?> Std.</td>
							</tr>
							<tr>
								<td><b>Fraktion:</b></td>
								<td><?=$factions[$userdata['Fraktion']]['name']?> (Rang <?=$userdata['FraktionsRang']?>)</td>
							</tr>
							<tr>
								<td><b>Job:</b></td>
								<td><?=(($userdata['Job'] != "none") ? ucfirst($userdata['Job']) : "-")?></td>
							</tr>
							<tr>
								<td><b>Sozialer Status:</b></td>
								<td><?=$userdata['SocialState']?></td>
							</tr>
							<tr>
								<td><b>Telefonnummer:</b></td>
								<td><?=$userdata['Telefonnr']?></td>
							</tr>
							<tr>
								<td><b>Bonuspunkte:</b></td>
								<td><?=number_format($userdata['Bonuspunkte'],0,"",".")?></td>
							</tr>
							<tr>
								<td><b>Warns:</b></td>
								<td>
									<?php
									$whereFIX = "player='".$players['Name']."'";
									if (SCRIPT_TYPE=='ultimate') {
										$whereFIX = "UID='".$players['UID']."'";
									}
									$sql = $mySQLcon->query("SELECT * FROM warns WHERE ".$whereFIX);
									echo $sql->num_rows;
									?>
									<br>
									<ul>
										<?php
										while ($row = $sql->fetch_assoc()) {
											echo '<li>Admin: '.((SCRIPT_TYPE=='ultimate') ? $CP->getNameFromUID($row['adminUID']) : $row['admin']).', Grund: '.$row['reason'].'</li>';
										}
										?>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php } else { ?>
				<p>Gib den Namen des Spielers ein welchen du Überprüfen möchtest.</p>
				<form role="form" action="?page=admin-checkplayer" method="post">
					<div class="form-group">
						<label>Spielername</label>
						<input class="form-control" type="text" name="nick" />
					</div>
					<button type="submit" class="btn btn-default" name="pwchange">Check</button>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>