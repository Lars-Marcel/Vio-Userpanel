<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Fraktion
			</div>
			<div class="panel-body">
				<?php if ($CP->UserData['userdata']['Fraktion'] == "0") { ?>
				<p>Du bist in keiner Fraktion.</p>
				<?php } else { ?>
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td>Fraktion</td>
								<td><?=$factions[$CP->UserData['userdata']['Fraktion']]['name']?></td>
							</tr>
							<tr>
								<td>Fraktions-Rang</td>
								<td><?=$CP->UserData['userdata']['FraktionsRang']?></td>
							</tr>
							<?php
							$sql = $mySQLcon->query("SELECT * FROM fraktionen WHERE ID='".$mySQLcon->escape_string($CP->UserData['userdata']['Fraktion'])."'");
							if ($sql->num_rows > 0) {
								$row = $sql->fetch_assoc();
								echo '<tr><td>Depot-Kasse</td><td>'.number_format($row['DepotGeld'],0,"",".").' $</td></tr>
								<tr><td>Depot-Drogen</td><td>'.number_format($row['DepotDrogen'],0,"",".").' Gramm</td></tr>
								<tr><td>Depot-Materials</td><td>'.number_format($row['DepotMaterials'],0,"",".").' Stk.</td></tr>';
							}
							?>
							<tr>
								<td>Mitglieder:</td>
								<td><?php
								$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='".$mySQLcon->escape_string($CP->UserData['userdata']['Fraktion'])."' ORDER BY FraktionsRang DESC");
								while ($row = $sql->fetch_array()) {
									$name = $row['Name'];
									$rank = $row['FraktionsRang'];
									echo $name.' - Rang '.$rank.'<br>';
								}
								?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Fraktions Leader
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Fraktion</th>
								<th>Leader</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($factions as $key => $value) {
								if ($key != 0) {
									$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Fraktion='$key' AND FraktionsRang='5'");
									$row = $sql->fetch_assoc();
									echo '<tr>
										<td>'.$value['name'].'</td>
										<td>'.((empty($row['Name'])) ? '-' : $row['Name']).'</td>
									</tr>';
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>