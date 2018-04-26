<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
if (!$CP->Banned) {
	header("Location: ?page=home");
	exit;
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-danger"><b>
			<?php
			$date = date_create('01.01.1900');
			$intv = new DateInterval('PT'.($CP->Banned['STime']).'M');
			date_add($date, $intv);
			$endTime = date_format($date, 'd.m.Y, H:i:s');
			
			$leftBanTime = round((((($CP->Banned['STime']-getSecTime(0))/60)*100)/100), 2);
			?>
			Du wurdest am <i><?=$CP->Banned['Datum']?> Uhr</i> von <i><?=((SCRIPT_TYPE=='ultimate') ? $CP->getNameFromUID($CP->Banned['AdminUID']) : $CP->Banned['Admin'])?></i> <?=(($CP->Banned['STime'] == "0") ? "permanent gebannt" : "gebannt. Du wirst in ".$leftBanTime." Std. (am ".$endTime." Uhr) entbannt")?> (Grund: <i><?=$CP->Banned['Grund']?></i>).
			<br>
			Während Du gebannt bist kannst Du das User-Panel nicht in vollem Umfang nutzen.
		</b></div>
	</div>
</div>