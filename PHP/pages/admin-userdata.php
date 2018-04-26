<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Spielerdaten bearbeiten
			</div>
			<div class="panel-body">
				<?php
				if (isset($_POST['nick']) && $CP->Adminlvl >= 3) {
					
					if (isset($_POST['edit'])) {
						$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Name LIKE '".$mySQLcon->escape_string($_POST['nick'])."'");
						$row = $sql->fetch_assoc();
						foreach ($row as $key => $val) {
							if ($key != "Name" && $_POST[$key] != $val) {
								$mySQLcon->query("UPDATE userdata SET ".$key."='".$mySQLcon->escape_string($_POST[$key])."' WHERE Name LIKE '".$mySQLcon->escape_string($_POST['nick'])."'");
							}
						}
						echo '<div class="alert alert-info">Änderung erfolgreich.</div>';
					}
				?>
				<form method="post" action="?page=admin-userdata">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Wert</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sql = $mySQLcon->query("SELECT * FROM userdata WHERE Name LIKE '".$mySQLcon->escape_string($_POST['nick'])."'");
								$row = $sql->fetch_assoc();
								
								foreach ($row as $key => $val) {
									echo '<tr>
										<th>'.$key.'</th>
										<th><input type="text" value="'.$val.'" name="'.$key.'" /></th>
									</tr>';
								}
								?>
							</tbody>
						</table>
					</div>
					<input type="hidden" name="nick" value="<?=$_POST['nick']?>" />
					<button type="submit" class="btn btn-default" name="edit">Speichern</button>
				</form>
				<?php
				} else {
					if ($CP->Adminlvl >= 3) {
				?>
				<p>Bitte gib einen Spielernamen ein.</p>
				<form role="form" action="?page=admin-userdata" method="post">
					<div class="form-group">
						<label>Spielername</label>
						<input class="form-control" type="text" name="nick" />
					</div>
					<button type="submit" class="btn btn-default" name="">Daten bearbeiten</button>
				</form>
				<?php
					} else {
				?>
				<p>Du benötigst mindestens Adminlevel 3.</p>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>