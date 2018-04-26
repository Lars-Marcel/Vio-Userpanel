<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Gebannte Spieler
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Gebannt von</th>
								<th>Gebannt am</th>
								<th>Grund</th>
								<th>Zeit</th>
								<th>Aktion</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql = $mySQLcon->query("SELECT * FROM ban");
							while($row = $sql->fetch_array()) {
								$name = ((SCRIPT_TYPE=='ultimate') ? $CP->getNameFromUID($row['UID']) : $row['Name']);
								$fix = "'".$name."'";
								echo '<tr>
									<td>'.$name.'</td>
									<td>'.((SCRIPT_TYPE=='ultimate') ? $CP->getNameFromUID($row['AdminUID']) : $row['Admin']).'</td>
									<td>'.$row['Datum'].'</td>
									<td>'.$row['Grund'].'</td>
									<td>'.(($row['STime'] == "0") ? "Permanent" : round((((($row['STime']-getSecTime(0))/60)*100)/100), 2).' Stunden').'</td>
									<td><a href="#" onclick="unban('.$fix.');">Spieler entbannen</a></td>
								</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function unban(name) {
	if (confirm(name+" Entbannen?")) {
		$.get("ajax/admin.php?action=unban&player="+name, function(data) {
			alert(data);
		});
	}
}
</script>