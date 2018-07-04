<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

$intern = false;
?>
<div class="row">
	<div class="col-md-12">
		<?php
		if ($CP->Loggedin) {
			header("Location: ?page=home");
			exit;
		}

		if (isset($_POST['login'])) {
			$sql = $mySQLcon->query("SELECT * FROM players WHERE Name='".$mySQLcon->escape_string($_POST['uname'])."'");
			if ($sql->num_rows > 0) {
				while ($row = $sql->fetch_assoc()) {
					$id					= ((!empty($row['id'])) ? $row['id'] : $row['UID']);
					$name				= $row['Name'];
					$pw					= $row['Passwort'];
					$salt				= ((!empty($row['Salt'])) ? $row['Salt'] : '');
					
					$passVioLite		= hash('md5', $_POST['password']);
					$passVioExtendet	= hash('md5', $_POST['password'].$salt);
					$passTHC			= hash('sha256', $_POST['password'].$salt);
					$passUltimate		= hash('sha512', strtolower(hash('sha512', $_POST['password'])));
					
					if (strtoupper($passVioLite) == strtoupper($pw) || strtoupper($passVioExtendet) == strtoupper($pw) || strtoupper($passTHC) == strtoupper($pw) || strtoupper($passUltimate) == strtoupper($pw)) {
						$exIP = explode('.', $_SERVER['REMOTE_ADDR']);
						$IPb = $exIP[0].".".$exIP[1];
						
						$auth = hash('sha256', $pw.$name.$salt.$IPb);
						setcookie("cpauth", $auth, time()+60*60*24*365);
						setcookie("cpuser", $id, time()+60*60*24*365);
						
						header("Location: ?page=home");
						exit;
					}
				}
			}
			echo '<div class="alert alert-danger"><b>Username oder Passwort Falsch.</b></div>';
		} else {
			echo '<div class="alert alert-info">Bitte logge dich mit deinen inGame-Daten ein, um Zugang zum Control-Panel zu erhalten.</div>';
		}
		?>
		<form role="form" method="post" action="?page=login" class="form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-2 control-label">Username:</label>
				<div class="col-sm-6">
					<input class="form-control" type="text" name="uname" placeholder="Username" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Passwort:</label>
				<div class="col-sm-6">
					<input class="form-control" type="password" name="password" placeholder="Passwort" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-6">
					<button type="submit" class="btn btn-primary btn-sm btn-block" name="login">Login</button>
				</div>
			</div>
		</form>
		<br>
		<a href="mtasa://<?=MTA_IP?>:<?=MTA_PORT?>/">Noch keinen Account?</a>
	</div>
</div>