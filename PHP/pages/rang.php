<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Geld (Hand u. Bank)
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Geld</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$geld = array();
							$sql = $mySQLcon->query("SELECT * FROM userdata");
							while ($row = $sql->fetch_object()) {
								$geld[$row->Name] = $row->Geld + $row->Bankgeld;
							}
							arsort($geld);
							
							$i = 1;
							foreach ($geld as $name => $val) {
								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$name.'</td>
									<td>'.number_format($val,0,"",".").' $</td>
								</tr>';
								if ($i == 10) { break; }
								$i++;
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
				Spielstunden
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Stunden</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							$sql = $mySQLcon->query("SELECT * FROM userdata ORDER BY Spielzeit DESC LIMIT 10");
							while ($row = $sql->fetch_object()) {
								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$row->Name.'</td>
									<td>'.floor($row->Spielzeit/60).':'.($row->Spielzeit%60).' Std.</td>
								</tr>';
								$i++;
							}
							?>
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
				Bonuspunkte
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Bonuspunkte</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							$sql = $mySQLcon->query("SELECT * FROM userdata ORDER BY Bonuspunkte DESC LIMIT 10");
							while ($row = $sql->fetch_object()) {
								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$row->Name.'</td>
									<td>'.number_format($row->Bonuspunkte,0,"",".").'</td>
								</tr>';
								$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php if (SCRIPT_TYPE != 'ultimate') { ?>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Kills
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Kills</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							$sql = $mySQLcon->query("SELECT * FROM userdata ORDER BY Kills DESC LIMIT 10");
							while ($row = $sql->fetch_object()) {
								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$row->Name.'</td>
									<td>'.number_format($row->Kills,0,"",".").'</td>
								</tr>';
								$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php if (SCRIPT_TYPE != 'ultimate') { ?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Tode
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Tode</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							$sql = $mySQLcon->query("SELECT * FROM userdata ORDER BY Tode DESC LIMIT 10");
							while ($row = $sql->fetch_object()) {
								echo '<tr>
									<td>'.$i.'</td>
									<td>'.$row->Name.'</td>
									<td>'.number_format($row->Tode,0,"",".").'</td>
								</tr>';
								$i++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>