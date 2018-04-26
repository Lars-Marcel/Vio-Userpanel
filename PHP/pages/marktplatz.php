<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Angebote
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-markt">
						<thead>
							<tr>
								<th id="sortFix">#</th>
								<th>Titel</th>
								<th>Verkäufer</th>
								<th>Endzeit</th>
								<th>Preis</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = $mySQLcon->query("SELECT * FROM marktplatz ORDER BY ID DESC");
							while ($row = $sql->fetch_assoc()) {
								if ($row['buyer'] == "") {
									if (strtotime($row['endtime']) >= time()) {
										
										echo "<tr onclick=\"offerDisplay(".$row['ID'].");\" data-toggle=\"modal\" data-target=\"#myModal\">
										<td>".$row['ID']."</td>
										<td>".$row['title']."</td>
										<td>".$row['seller']."</td>
										<td>".date('d-m-Y, H:i:s', strtotime($row['endtime']))."</td>
										<td>".number_format($row['price'],0,"",".")." $</td>
										</tr>\n";
										
									}
								}
							}
							?>
						</tbody>
					</table>
					<script>
					$('#dataTables-markt').dataTable(
						"order": [[ 0, "desc" ]],
					);
					</script>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Angebot erstellen
			</div>
			<div class="panel-body">
				<?php
				if (isset($_POST['title'])) {
					$err = "";
					
					if (strlen($_POST['title']) > 5) {
						if (strlen($_POST['objecttyp']) > 0) {
							if (($_POST['objecttyp'] == "vehicle" && $_POST['vehicle'] != "") || ($_POST['objecttyp'] != "vehicle")) {
								if (is_numeric($_POST['price']) && (int)$_POST['price'] > 0) {
									if (strlen($_POST['description']) > 10) {
										
										$title = strip_tags($_POST['title']);
										$desc = strip_tags($_POST['description']);
										$objID = (($_POST['objecttyp'] == "vehicle") ? $_POST['vehicle'] : '');
										$tm = (($typ == "Bieten") ? '5' : '10');
										
										$mySQLcon->query("INSERT INTO marktplatz (ID, seller, title, description, price, buyer, starttime, endtime, objecttyp, objectID) VALUES (NULL, '".$mySQLcon->escape_string($CP->Name)."', '".$mySQLcon->escape_string($title)."', '".$mySQLcon->escape_string($desc)."', '".$mySQLcon->escape_string($_POST['price'])."', '', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s', strtotime('+'.MARKTPLATZ_OFFER_DAYS.' days'))."', '".$mySQLcon->escape_string($_POST['objecttyp'])."', '".$mySQLcon->escape_string($objID)."')");
										
										echo '<div class="alert alert-info">Dein Angebot wurde erstellt.</div>';
										
									} else {
										$err = 'Du musst eine (längere) Beschreibung angeben.';
									}
									
								} else {
									$err = 'Gib einen gültigen Preis an.';
								}
								
							} else {
								$err = 'Du musst das Fahrzeug auswählen das Du verkaufen möchtest.';
							}
						} else {
							$err = 'Du musst einen Objekttyp auswählen.';
						}
					} else {
						$err = 'Du musst einen (längeren) Titel angeben.';
					}
					
					if ($err != "") {
						echo '<div class="alert alert-danger"><b>Fehler:</b> '.$err.'</div>';
					}
				}
				?>
				<form role="form" method="post" action="?page=marktplatz">
					<div class="form-group">
						<label>Angebotstitel</label>
						<input class="form-control" type="text" name="title" maxlength="40" />
					</div>
					
					<?php
					$whereFIX = ((SCRIPT_TYPE=='ultimate') ? "UID='".$mySQLcon->escape_string($CP->UID)."'" : "Inhaber='".$mySQLcon->escape_string($CP->Name)."'");
					$sql = $mySQLcon->query("SELECT * FROM biz WHERE ".$whereFIX);
					$hasBIZ = (($sql->num_rows>0) ? true : false);
					
					$whereFIX = ((SCRIPT_TYPE=='ultimate') ? "UID='".$mySQLcon->escape_string($CP->UID)."'" : "Besitzer='".$mySQLcon->escape_string($CP->Name)."'");
					$sql = $mySQLcon->query("SELECT * FROM prestige WHERE ".$whereFIX);
					$hasPrestige = (($sql->num_rows>0) ? true : false);
					?>
					<div class="form-group">
						<label>Objekttyp</label>
						<select class="form-control" name="objecttyp" id="objecttyp">
							<option value="">Bitte auswählen</option>
							<option value="vehicle">Fahrzeug</option>
							<option value="biz"<?=(($hasBIZ) ? '' : ' disabled="true"')?>>BIZ</option>
							<option value="prestige"<?=(($hasPrestige) ? '' : ' disabled="true"')?>>Prestige</option>
							<option value="drugs">Drogen</option>
							<option value="mats">Mats</option>
							<option value="weapon">Waffe</option>
							<option value="other">Anderes</option>
						</select>
					</div>
					<div class="form-group" id="vSelect" style="display:none;">
						<label>Fahrzeug</label>
						<select class="form-control" name="vehicle">
							<option value="">-</option>
							<?php
							$whereFIX = ((SCRIPT_TYPE=='ultimate') ? "UID='".$mySQLcon->escape_string($CP->UID)."'" : "Besitzer='".$mySQLcon->escape_string($CP->Name)."'");
							$sql = $mySQLcon->query("SELECT * FROM vehicles WHERE ".$whereFIX);
							while ($row = $sql->fetch_array()) {
								echo '<option value="'.$row['Typ'].'">Slot '.$row['Slot'].' - '.$vehname[$row['Typ']].'</option>';
							}
							?>
						</select>
					</div>
					<script>
					$("#objecttyp").change(function() {
						if ($("#objecttyp option:selected").text() == "Fahrzeug") {
							$('#vSelect').css('display', '');
						} else {
							$('#vSelect').css('display', 'none');
						}
					});
					</script>
					
					<div class="form-group">
						<label>Preis</label>
						<input class="form-control" type="text" name="price" placeholder="100000" maxlength="15" />
					</div>
					
					<div class="form-group">
						<label>Beschreibung</label>
						<textarea class="form-control" rows="4" name="description" maxlength="1000"></textarea>
					</div>
					<button type="submit" class="btn btn-default">Angebot erstellen</button>
				</form>
				
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Meine Angebote
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-markt_my">
						<thead>
							<tr>
								<th id="sortFix">#</th>
								<th>Titel</th>
								<th>Endzeit</th>
								<th>Preis</th>
								<th>Verkauft</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = $mySQLcon->query("SELECT * FROM marktplatz WHERE seller LIKE '".$mySQLcon->escape_string($CP->Name)."' ORDER BY ID DESC");
							while ($row = $sql->fetch_assoc()) {
								$FIX = "onclick=\"offerDisplay(".$row['ID'].");\" data-toggle=\"modal\" data-target=\"#myModal\"";
								if ($row['buyer'] != "") { $FIX = ""; }
								
								echo "<tr $FIX>
								<td>".$row['ID']."</td>
								<td>".$row['title']."</td>
								<td>".date('d-m-Y, H:i:s', strtotime($row['endtime']))."</td>
								<td>".number_format($row['price'],0,"",".")." $</td>
								<td>".(($row['buyer']=="") ? 'Nein' : 'An: '.$row['buyer'])."</td>
								</tr>\n";
								
							}
							?>
						</tbody>
					</table>
					<script>
					$('#dataTables-markt_my').dataTable(
						"order": [[ 0, "desc" ]],
					);
					</script>
				</div>
				
				<hr></hr>
				
				<p><b>Gekaufte</b></p>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="dataTables-markt_selled">
						<thead>
							<tr>
								<th id="sortFix">#</th>
								<th>Titel</th>
								<th>Endzeit</th>
								<th>Preis</th>
								<th>Verkäufer</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = $mySQLcon->query("SELECT * FROM marktplatz WHERE buyer LIKE '".$mySQLcon->escape_string($CP->Name)."' ORDER BY ID DESC");
							while ($row = $sql->fetch_assoc()) {
								
								echo "<tr>
								<td>".$row['ID']."</td>
								<td>".$row['title']."</td>
								<td>".date('d-m-Y, H:i:s', strtotime($row['endtime']))."</td>
								<td>".number_format($row['price'],0,"",".")." $</td>
								<td>".$row['seller']."</td>
								</tr>\n";
								
							}
							?>
						</tbody>
					</table>
					<script>
					$('#dataTables-markt_selled').dataTable(
						"order": [[ 0, "desc" ]],
					);
					</script>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">TITLE</h4>
			</div>
			<div class="modal-body">
				
				<table class="table">
					<tbody>
						<td width="50%" align="center">
							<img id="offerImg" src="" alt="" width="100%" />
						</td>
						<td width="50%" align="left">
							<table class="table">
								<tbody>
									<tr>
										<td><b>Verkäufer</b></td>
										<td id="offer-seller">Spielername</td>
									</tr>
									<tr>
										<td><b>Preis</b></td>
										<td id="offer-price">PRICE</td>
									</tr>
									<tr>
										<td><b>Endzeit</b></td>
										<td id="offer-endtime">ENDTIME</td>
									</tr>
								</tbody>
							</table>
							<center><button id="buyBtn" type="button" onclick="" class="btn btn-success">Jetzt Kaufen!</button></center>
						</td>
					</tbody>
				</table>
				
				
				
				<p><b>Beschreibung:</b></p>
				<div class="alert alert-info" id="offer-description">
					DESC
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" style="display:none;" id="delOfferBtn" onclick="">Angebot löschen</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
			</div>
		</div>
	</div>
</div>

<script>
function offerDisplay(id) {
	$.get("ajax/marktplatz.php?id="+id, function(data) {
		
		var json = $.parseJSON(data);
		if (json != null && json.length < 1) { return false; }
		if (json['state'] != true) { alert(json['msg']); return false; }
		
		json = json['data'];
		
		
		var image = json['objecttyp']+".png";
		if (json['objecttyp'] == "vehicle") {
			image = "vehicles/"+json['objectID']+".png";
		}
		$('#offerImg').attr("src", "assets/img/marktplatz/"+image);
		
		$('#myModalLabel').html(json['title']);
		$('#offer-seller').html(json['seller']);
		$('#offer-price').html(json['price']+" $");
		$('#offer-endtime').html(json['endtime']);
		$('#offer-description').html(json['description']);
		
		$('#buyBtn').attr("onclick", "offerBuy("+id+");");
		
		if (json['myOffer'] == true) {
			$('#delOfferBtn').css("display", "");
			$('#delOfferBtn').attr("onclick", "offerDel("+id+");");
		}
		
	});
}
function offerBuy(id) {
	$.get("ajax/marktplatz.php?id="+id+"&act=buy", function(data) {
		var json = $.parseJSON(data);
		if (json != null && json.length < 1) { return false; }
		if (json['state'] == true) {
			
			alert(json['msg']);
			window.location.reload();
			
		} else {
			alert(json['msg']);
		}
	});
}
function offerDel(id) {
	$.get("ajax/marktplatz.php?id="+id+"&act=del", function(data) {
		var json = $.parseJSON(data);
		if (json != null && json.length < 1) { return false; }
		if (json['state'] == true) {
			
			alert('Dein Angebot wurde gelöscht!');
			window.location.reload();
			
		} else {
			alert(json['msg']);
		}
	});
}
</script>