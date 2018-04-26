<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Inventar
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Item</th>
								<th>Anzahl</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Würfel</td>
								<td><?=$CP->UserData['inventar']['Wuerfel']?></td>
							</tr>
							<tr>
								<td>Zigaretten</td>
								<td><?=number_format($CP->UserData['inventar']['Zigaretten'],0,"",".")?></td>
							</tr>
							<tr>
								<td>Materials</td>
								<td><?=number_format($CP->UserData['inventar']['Materials'],0,"",".")?></td>
							</tr>
							<tr>
								<td>Drogen</td>
								<td><?=number_format($CP->UserData['userdata']['Drogen'],0,"",".")?></td>
							</tr>
							<tr>
								<td>Benzinkanister</td>
								<td><?=number_format($CP->UserData['inventar']['Benzinkanister'],0,"",".")?></td>
							</tr>
							<tr>
								<td>Casino Chips</td>
								<td><?=number_format($CP->UserData['inventar']['Chips'],0,"",".")?></td>
							</tr>
							<tr>
								<td>Geschenke</td>
								<td><?=number_format($CP->UserData['inventar']['Geschenke'],0,"",".")?></td>
							</tr>
							<tr>
								<td>Ostereier</td>
								<td><?=number_format($CP->UserData['inventar']['eggs'],0,"",".")?></td>
							</tr>
							<tr>
								<?php
								$spezmun = explode("|", $CP->UserData['inventar']['Spezial']);
								?>
								<td>Phosphor-Munition</td>
								<td><?=number_format($spezmun[1],0,"",".")?></td>
							</tr>
							<tr>
								<td>Dumdum-Munition</td>
								<td><?=number_format($spezmun[2],0,"",".")?></td>
							</tr>
							<tr>
								<td>Panzer-Munition</td>
								<td><?=number_format($spezmun[3],0,"",".")?></td>
							</tr>
							<tr>
								<td>Vulcano-Munition</td>
								<td><?=number_format($spezmun[4],0,"",".")?></td>
							</tr>
							<tr>
								<td>Pfeffer-Munition</td>
								<td><?=number_format($spezmun[5],0,"",".")?></td>
							</tr>
							<tr>
								<td>Halloween-Munition</td>
								<td><?=number_format($spezmun[6],0,"",".")?></td>
							</tr>
							<tr>
								<?php
								$huf = explode("|", $CP->UserData['achievments']['Hufeisen']);
								$hufeisen = 0;
								for ($i = 0; $i <= 24; $i++) {
									$hufeisen = $hufeisen + $huf[$i];
								}
								?>
								<td>Hufeisen</td>
								<td><?=$hufeisen?>/25</td>
							</tr>
							<tr>
								<?php
								$look = explode("|", $CP->UserData['achievments']['LookoutsA']);
								$lookouts = 0;
								for ($i = 0; $i <= 9; $i++) {
									$lookouts = $lookouts + $look[$i];
								}
								?>
								<td>Aussichtspunkte</td>
								<td><?=$lookouts?>/10</td>
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Waffenbox
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<td width="33%" align="center">
								<b>Slot 1</b>
								<br>
								<?php
								$weaponID = "0";
								$weapon = "Leer";
								$ammo = "0";
								
								$slot = $CP->UserData['userdata']['Gunbox1'];
								if ($slot != "0") {
									$slot = explode('|', $slot);
									$weaponID = $slot[0];
									$weapon = $weaponNames[$slot[0]];
									$ammo = number_format($slot[1],0,"",".");
								}
								?>
								<img src="assets/img/weapons/weapon_<?=$weaponID?>.png" width="64" style="margin: 5px;">
								<br>
								<?=$weapon?>
								<br>
								<?=$ammo?> Schuss
							</td>
							
							<td width="33%" align="center">
								<b>Slot 2</b>
								<br>
								<?php
								$weaponID = "0";
								$weapon = "Leer";
								$ammo = "0";
								
								$slot = $CP->UserData['userdata']['Gunbox2'];
								if ($slot != "0") {
									$slot = explode('|', $slot);
									$weaponID = $slot[0];
									$weapon = $weaponNames[$slot[0]];
									$ammo = number_format($slot[1],0,"",".");
								}
								?>
								<img src="assets/img/weapons/weapon_<?=$weaponID?>.png" width="64" style="margin: 5px;">
								<br>
								<?=$weapon?>
								<br>
								<?=$ammo?> Schuss
							</td>
							
							<td width="33%" align="center">
								<b>Slot 3</b>
								<br>
								<?php
								$weaponID = "0";
								$weapon = "Leer";
								$ammo = "0";
								
								$slot = $CP->UserData['userdata']['Gunbox3'];
								if ($slot != "0") {
									$slot = explode('|', $slot);
									$weaponID = $slot[0];
									$weapon = $weaponNames[$slot[0]];
									$ammo = number_format($slot[1],0,"",".");
								}
								?>
								<img src="assets/img/weapons/weapon_<?=$weaponID?>.png" width="64" style="margin: 5px;">
								<br>
								<?=$weapon?>
								<br>
								<?=$ammo?> Schuss
							</td>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>