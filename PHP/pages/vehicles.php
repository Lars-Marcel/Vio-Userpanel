<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Fahrzeuge
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Fahrzeug / Slot</th>
								<th>Tunings</th>
								<th>Kofferraum</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$whereFIX = ((SCRIPT_TYPE=='ultimate') ? "UID='".$mySQLcon->escape_string($CP->UID)."'" : "Besitzer='".$mySQLcon->escape_string($CP->Name)."'");
							$sql = $mySQLcon->query("SELECT * FROM vehicles WHERE ".$whereFIX);
							while ($row = $sql->fetch_assoc()) {
								$tunings = explode('|', $row['STuning']);
								$koff = explode('|', $row['Kofferraum']);
								
								$kofferraum = "Kein Kofferraum vorhanden.";
								if ($tunings[0] == "1") {
									$kofferraum = "Drogen: ".number_format($koff[0],0,"",".")." Gramm<br>Mats: ".number_format($koff[1],0,"",".")." Stk.<br>Waffe: ".(($koff[2] == 0) ? "-" : $weaponNames[$koff[2]])." / ".(($koff[3] > 0) ? number_format($koff[3],0,"",".")." Schuss" : "-");
								}
								
								$mapFIX = "displayMap('".$row['Spawnpos_X']."', '".$row['Spawnpos_Y']."');";
								echo '<tr>
								<td>'.$vehname[$row['Typ']].'<br>Slot '.$row['Slot'].'<br><br>'.getZoneName($row['Spawnpos_X'], $row['Spawnpos_Y'], 0, true).", ".getZoneName($row['Spawnpos_X'], $row['Spawnpos_Y'], 0, false).'<br><a href="#" onclick="'.$mapFIX.'">Position auf der Karte anzeigen</a></td>
								<td>
									Kofferraum: ['.(($tunings[0] == "1") ? "x" : "").']<br>
									Panzerung: ['.(($tunings[1] == "1") ? "x" : "").']<br>
									Benzinersparnis: ['.(($tunings[2] == "1") ? "x" : "").']<br>
									GPS: ['.(($tunings[3] == "1") ? "x" : "").']<br>
									Doppelreifen: ['.(($tunings[4] == "1") ? "x" : "").']<br>
									Nebelwerfer: ['.(($tunings[5] == "1") ? "x" : "").']
									'.((SCRIPT_TYPE=='ultimate') ?
									'<br><br>Antrieb: '.(($row['Antrieb'] == "awd") ? "Allrad" : (($row['Antrieb'] == "fwd") ? "Frontantrieb" : "Heckantrieb")).'<br>Bremse: Stufe '.$row['Bremse'].'<br>Sportmotor: Stufe '.$row['Sportmotor'] : '').'
								</td>
								<td>'.$kofferraum.'</td>
							</tr>';
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
				Vehicle-Map
			</div>
			<div class="panel-body">
				<img id="map" src="ajax/map.php?x=999999&y=999999" width="100%" />
			</div>
		</div>
	</div>
</div>