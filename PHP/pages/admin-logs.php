<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Log: <?=((SCRIPT_TYPE=='ultimate') ? $LogNamesUltimate[($_GET['log'])] : $_GET['log'])?>
			</div>
			<div class="panel-body">
				<textarea rows="25" cols="75"><?php
				if (SCRIPT_TYPE=='ultimate') {
					$sql = $mySQLcon->query("SELECT * FROM logs WHERE Typ='".$mySQLcon->escape_string($_GET['log'])."' ORDER BY Timestamp DESC LIMIT 1000");
					while ($row = $sql->fetch_array()) {
						echo $row['Text']."\n";
					}
				} else {
					ob_start();
					$mtaServer = new mta(MTA_IP, MTA_HTTP_PORT, MTA_USER, MTA_PASS);
					$resource = $mtaServer->getResource(MTA_RESOURCE_NAME);
					$action = $resource->call("getLogContent", $_GET['log']);
					ob_end_clean();
					echo $action[0];
				}
				?></textarea>
			</div>
		</div>
	</div>
</div>