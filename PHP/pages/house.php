<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Haus
			</div>
			<div class="panel-body">
				<?php if ($CP->UserData['userdata']['Hausschluessel'] == "0") { ?>
				<p>Du besitzt oder wohnst in keinem Haus.</p>
				<?php } else { ?>
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<?php
							$hs = str_replace('-', '', $CP->UserData['userdata']['Hausschluessel']);
							$sql = $mySQLcon->query("SELECT * FROM houses WHERE ID='".$mySQLcon->escape_string($hs)."'");
							$row = $sql->fetch_assoc();
							
							$pX = $row['SymbolX'];
							$pY = $row['SymbolY'];
							$owner = ((SCRIPT_TYPE=='ultimate') ? $CP->getNameFromUID($row['UID']) : $row['Besitzer']);
							?>
							<tr>
								<td>ID</td>
								<td><?=$row['ID']?></td>
							</tr>
							<tr>
								<td>Besitzer</td>
								<td><?=$owner?></td>
							</tr>
							<tr>
								<td>Preis</td>
								<td><?=number_format($row['Preis'],0,"",".")?> $</td>
							</tr>
							<tr>
								<td>Miete</td>
								<td><?=number_format($row['Miete'],0,"",".")?> $</td>
							</tr>
							<tr>
								<td>Erforderliche Spielzeit</td>
								<td><?=$row['Mindestzeit']?> Std.</td>
							</tr>
							<tr>
								<td>Position</td>
								<td><?=getZoneName($pX, $pY, 0, true).", ".getZoneName($pX, $pY, 0, false)?></td>
							</tr>
							<?php if ($owner == $CP->Name) { ?>
							<tr>
								<td>Kasse</td>
								<td><?=number_format($row['Kasse'],0,"",".")?> $</td>
							</tr>
							<?php } ?>
							<tr>
								<td>Mieter</td>
								<td><?php
								$out = "";
								$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Hausschluessel='-".$mySQLcon->escape_string($hs)."'");
								while ($row = $sql->fetch_array()) {
									$out .= $row['Name'].", ";
								}
								$out .= ",";
								$mieter = str_replace(', ,', '', $out);
								if ($mieter == ",") {
									$mieter = "Keine";
								}
								echo $mieter;
								?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<br>
				<a href="#" onclick="displayMap('<?=$pX?>', '<?=$pY?>');">Position auf der Karte anzeigen</a>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Map
			</div>
			<div class="panel-body">
				<img id="map" src="ajax/map.php?x=999999&y=999999" width="100%" />
			</div>
		</div>
	</div>
</div>




<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Verfügbare Häuser
			</div>
			<div class="panel-body">
				<p>Klick auf eine Zeile, um die Position auf der Karte anzuzeigen.</p>
				<br>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Ort</th>
								<th>Erforderliche Spielzeit</th>
								<th>Preis</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$whereFIX = ((SCRIPT_TYPE=='ultimate') ? "UID='0'" : "Besitzer='none'");
							$sql = $mySQLcon->query("SELECT * FROM houses WHERE ".$whereFIX);
							while ($row = $sql->fetch_assoc()) {
								
								echo "<tr onclick=\"displayMap(".$row['SymbolX'].",".$row['SymbolY'].");showHouseInt(".$row['CurrentInterior'].");\">
								<td>".$row['ID']."</td>
								<td>".getZoneName($row['SymbolX'], $row['SymbolY'], $row['SymbolZ'], true).", ".getZoneName($row['SymbolX'], $row['SymbolY'], $row['SymbolZ'], false)."</td>
								<td>".(int)$row['Mindestzeit']." Std.</td>
								<td>".number_format($row['Preis'],0,"",".")." $</td>
								</tr>\n";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>