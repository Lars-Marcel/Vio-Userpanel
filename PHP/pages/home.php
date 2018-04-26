<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Infos
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td rowspan="23" width="150"><img src="assets/img/skins/<?=$CP->UserData['userdata']['Skinid']?>.png" alt=""></td>
								<td height="23" align="left"><b>Name:</b></td>
								<td><?=$CP->Name?></td>
							</tr>
							<tr>
								<td height="23"><b>Registrierungsdatum:</b></td>
								<td><?=$CP->UserData['players']['RegisterDatum']?></td>
							</tr>
							<tr>
								<td height="23"><b>Letzter Login:</b></td>
								<td><?=$CP->UserData['players']['Last_login']?></td>
							</tr>
						</tbody>
					</table>
					
					<table class="table">
						<tbody>
							<tr>
								<td width="150" height="23"><b>Geld:</b></td>
								<td><?=number_format($CP->UserData['userdata']['Geld'],0,"",".")?> $ (Hand), <?=number_format($CP->UserData['userdata']['Bankgeld'],0,"",".")?> $ (Bank)</td>
							</tr>
							<tr>
								<td height="23"><b>Spielzeit:</b></td>
								<td><?=floor($CP->UserData['userdata']['Spielzeit']/60).":".($CP->UserData['userdata']['Spielzeit']%60)?> Std.</td>
							</tr>
							<tr>
								<td height="23"><b>Fraktion:</b></td>
								<td><?=$factions[$CP->UserData['userdata']['Fraktion']]['name']?> (Rang <?=$CP->UserData['userdata']['FraktionsRang']?>)</td>
							</tr>
							<tr>
								<td height="23"><b>Job:</b></td>
								<td><?=(($CP->UserData['userdata']['Job'] != "none") ? ucfirst($CP->UserData['userdata']['Job']) : "-")?></td>
							</tr>
							<tr>
								<td height="23"><b>Sozialer Status:</b></td>
								<td><?=$CP->UserData['userdata']['SocialState']?></td>
							</tr>
							<tr>
								<td height="23"><b>Telefonnummer:</b></td>
								<td><?=$CP->UserData['userdata']['Telefonnr']?></td>
							</tr>
							<tr>
								<td height="23"><b>Bonuspunkte:</b></td>
								<td><?=number_format($CP->UserData['userdata']['Bonuspunkte'],0,"",".")?></td>
							</tr>
							<tr>
								<td height="23"><b>STVO-Punkte:</b></td>
								<td><?=$CP->UserData['userdata']['StvoPunkte']?></td>
							</tr>
							<tr>
								<td height="23"><b>Warns:</b></td>
								<td><?=$CP->UserData['userdata']['Warns']?></td>
							</tr>
							<?php if (SCRIPT_TYPE!='ultimate') { ?>
							<tr>
								<td height="23"><b>Kills:</b></td>
								<td><?=number_format($CP->UserData['userdata']['Kills'],0,"",".")?></td>
							</tr>
							<tr>
								<td height="23"><b>Tode:</b></td>
								<td><?=number_format($CP->UserData['userdata']['Tode'],0,"",".")?></td>
							</tr>
							<tr>
								<td height="23"><b>Kill/Death-Ratio:</b></td>
								<td><?=(($CP->UserData['userdata']['Kills']+$CP->UserData['userdata']['Tode'] > 0) ? round($CP->UserData['userdata']['Kills']/$CP->UserData['userdata']['Tode'], 2) : 0)?></td>
							</tr>
							<?php } ?>
							<tr>
								<td height="23"><b>GWD-Note:</b></td>
								<?php
								$ex = explode('|', $CP->UserData['userdata']['ArmyPermissions']);
								?>
								<td><?=$ex[((SCRIPT_TYPE=='ultimate') ? 10 : 9)]?> %</td>
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
				Achievments
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td height="23">Angler</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['Angler'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Chicken Dinner</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['ChickenDinner'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Der Sammler</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['DerSammler'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Eigene Füße</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['EigeneFuesse'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Highscore</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['highscore'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Highway to Hell</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['HighwayToHell'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">King of the Hill</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['KingOfTheHill'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Mr. License</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['Lizensen'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Nichts geht mehr</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['NichtGehtMehr'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Reallife WTF?</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['ReallifeWTF'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Revolverheld</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['Revolverheld'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Schlaflos in SA</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['SchlaflosInSA'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Silent Assasin</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['SilentAssasin'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">The Truth is out there</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['TheTruthIsOutThere'] == 'done') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr>
								<td height="23">Waffenschieber</td>
								<td><img src="assets/img/<?=(($CP->UserData['achievments']['Waffenschieber'] != "0") ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Scheine
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr height="22">
								<td valign="top">Autoführerschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Autofuehrerschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Motorradführerschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Motorradtfuehrerschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">LKW-Führerschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['LKWfuehrerschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Helikopterführerschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Helikopterfuehrerschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Flugschein Klasse A</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['FlugscheinKlasseA'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Flugschein Klasse B</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['FlugscheinKlasseB'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Motorbootschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Motorbootschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Seegelschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Segelschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Angelschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Angelschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Waffenschein</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Waffenschein'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Personalausweiß</td>
								<td><img src="assets/img/<?=(($CP->UserData['userdata']['Perso'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		
		<div class="panel panel-default">
			<div class="panel-heading">
				Spieler Online
			</div>
			<div class="panel-body">
				<?php
				$online = 0;
				$out;
				
				$sql = $mySQLcon->query("SELECT * FROM loggedin WHERE Loggedin='1'");
				if ($sql->num_rows > 0) {
					while ($row = $sql->fetch_array()) {
						$whereFIX = "Name LIKE '".$mySQLcon->escape_string($row['Name'])."'";
						if (SCRIPT_TYPE == 'ultimate') {
							$whereFIX = "UID LIKE '".$mySQLcon->escape_string($row['UID'])."'";	
						}
						$sqlP = $mySQLcon->query("SELECT * FROM userdata WHERE ".$whereFIX);
						if ($sqlP->num_rows > 0) {
							$rowP = $sqlP->fetch_assoc();
							$out .= '<span style="color:rgb('.$factions[$rowP['Fraktion']]['rgb'].');">'.$rowP['Name'].'</span>, ';
							$online++;
						}
					}
				}
				?>
				<p>
					Zur Zeit <?=(($online == 1) ? "ist" : "sind")?> <b><?=$online?></b> Spieler Online:
				</p>
				<?=((empty($out)) ? "" : str_replace(', ,', '', $out.','))?>
				<p>
					Legende:
				</p>
				<?php
				$out2;
				foreach ($factions as $key => $val) {
					$out2 .= '<span style="color:rgb('.$val["rgb"].');">'.(($val["name"] == "-") ? "Zivilist" : $val["name"]).'</span>, ';
				}
				echo str_replace(', ,', '', $out2.',');
				?>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Skills
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							
							<tr height="22">
								<td colspan="2"><b>Fahrzeuge:</b></td>
							</tr>
							<tr height="22">
								<td valign="top">Fahrzeugslots</td>
								<?php
								$fix = "true";
								$slots = 3;
								if ($CP->UserData['bonustable']['CarslotUpgrades3'] == "1") {
									$slotsyy = 10;
								} else if ($CP->UserData['bonustable']['CarslotUpgrades2'] == "1") {
									$slots = 7;
								} else if ($CP->UserData['bonustable']['CarslotUpgrades'] == "buyed") {
									$slots = 5;
								} else {
									$fix = "false";
								}
								?>
								<td><img src="assets/img/<?=$fix?>.png" width="16" height="16" alt=""> (<?=$slots?> Slots)</td>
							</tr>
							<tr height="22">
								<td valign="top">Vortex</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Vortex'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Skimmer</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Skimmer'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Caddy</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Caddy'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Leichenwagen</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Leichenwagen'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Quad</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Quad'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							
							<tr height="22">
								<td colspan="2"><br><b>Items:</b></td>
							</tr>
							<tr height="22">
								<td valign="top">Fernglas</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['fglass'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Gameboy</td>
								<td><img src="assets/img/<?=(($CP->UserData['inventar']['Gameboy'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Notebook</td>
								<td><img src="assets/img/<?=(($CP->UserData['inventar']['FruitNotebook'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Schachspiel</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Schach'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							
							<tr height="22">
								<td colspan="2"><br><b>Kampfstile:</b></td>
							</tr>
							<tr height="22">
								<td valign="top">Boxen</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Boxen'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Kung-Fu</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['KungFu'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Streetfighting</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Streetfighting'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							
							<tr height="22">
								<td colspan="2"><br><b>Körperlich:</b></td>
							</tr>
							<tr height="22">
								<td valign="top">Lungenvolumen</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Lungenvolumen'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Muskeln</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Muskeln'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Kondition</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['Kondition'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							
							<tr height="22">
								<td colspan="2"><br><b>Skins:</b></td>
							</tr>
							<tr height="22">
								<td valign="top">Cluckin Bell</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['BonusSkin1'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							
							<tr height="22">
								<td colspan="2"><br><b>Waffenskills:</b></td>
							</tr>
							<tr height="22">
								<td valign="top">Pistole</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['PistolenSkill'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Deagle</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['DeagleSkill'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Sturmgewehr</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['AssaultSkill'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Schrotflinten</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['ShotgunSkill'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">MP5</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['MP5Skills'] == 'buyed') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
							<tr height="22">
								<td valign="top">Doppel SMG</td>
								<td><img src="assets/img/<?=(($CP->UserData['bonustable']['uzi'] == '1') ? 'true' : 'false')?>.png" width="16" height="16" alt=""></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>