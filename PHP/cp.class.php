<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

class CP {	
	var $mySQLcon		= false;
	
	var $Loggedin		= null;
	var $Name			= null;
	var $UID			= null;
	var $Admin			= null;
	var $Adminlvl		= null;
	var $Banned			= null;
	var $UserData 		= null;
	var $inGameLoggedin = null;
	var $Coins 			= null;
	var $LeftVIPDays 	= null;
	
	
	public function __construct($con) {
		if ($con->connect_errno) { return false; }
		$this->mySQLcon = $con;
		
		// Funktionen aufrufen, Variablen in Klasse speichern.
		$this->Loggedin = $this->isLoggedin();
		if ($this->Loggedin == true) {
			$this->Banned			= $this->isBanned();
			$this->UserData			= $this->getUserData();
			$this->inGameLoggedin	= $this->isInGameLoggedin();
			$this->Adminlvl			= $this->UserData['userdata']['Adminlevel'];
			$this->Admin			= (($this->Adminlvl > 0) ? true : false);
			$this->Coins 			= $this->UserData['coins']['Coins'];
			$this->LeftVIPDays		= $this->checkPlayerVIP();
		}
		
	}
	
	public function __destruct() {}
	
	// Private functions
	private function isLoggedin() {
		if (isset($_COOKIE['cpuser']) && !empty($_COOKIE['cpuser'])) {
			if (isset($_COOKIE['cpauth']) && !empty($_COOKIE['cpauth'])) {
				
				$whereFIX = "id='".$this->mySQLcon->escape_string($_COOKIE['cpuser'])."'";
				if (SCRIPT_TYPE == 'ultimate') {
					$whereFIX = "UID='".$this->mySQLcon->escape_string($_COOKIE['cpuser'])."'";
				}
				$sql = $this->mySQLcon->query("SELECT * FROM players WHERE ".$whereFIX);
				while ($row = $sql->fetch_assoc()) {
					$id			= ((!empty($row['id'])) ? $row['id'] : $row['UID']);
					$name		= $row['Name'];
					$pw			= $row['Passwort'];
					$salt		= ((!empty($row['Salt'])) ? $row['Salt'] : '');
					
					$this->Name = $name;
					$this->UID	= $id;
					
					$exIP		= explode('.', $_SERVER['REMOTE_ADDR']);
					$IPb		= $exIP[0].".".$exIP[1];
					$cookie		= hash('sha256', $pw.$name.$salt.$IPb);
					
					if ($_COOKIE['cpauth'] == $cookie) {
						return true;
					}
				}
			}
		}
		return false;
	}
	
	private function isBanned() {
		$whereFIX = "Name='".$this->mySQLcon->escape_string($this->Name)."'";
		if (SCRIPT_TYPE == 'ultimate') {
			$whereFIX = "UID='".$this->mySQLcon->escape_string($this->UID)."'";
		}
		$sql = $this->mySQLcon->query("SELECT * FROM ban WHERE ".$whereFIX);
		if ($sql->num_rows > 0) {
			$row = $sql->fetch_assoc();
			return $row;
		}
		return false;
	}
	
	private function getUserData() {
		$arr = array();
		
		$whereFIX = "Name='".$this->mySQLcon->escape_string($this->Name)."'";
		if (SCRIPT_TYPE == 'ultimate') {
			$whereFIX = "UID='".$this->mySQLcon->escape_string($this->UID)."'";
		}
		
		$sql = $this->mySQLcon->query("SELECT * FROM userdata WHERE ".$whereFIX);
		$arr["userdata"] = $sql->fetch_assoc();
		
		$sql = $this->mySQLcon->query("SELECT * FROM achievments WHERE ".$whereFIX);
		$arr["achievments"] = $sql->fetch_assoc();
		
		$sql = $this->mySQLcon->query("SELECT * FROM bonustable WHERE ".$whereFIX);
		$arr["bonustable"] = $sql->fetch_assoc();
		
		$sql = $this->mySQLcon->query("SELECT * FROM players WHERE ".$whereFIX);
		$arr["players"] = $sql->fetch_assoc();
		
		$sql = $this->mySQLcon->query("SELECT * FROM inventar WHERE ".$whereFIX);
		$arr["inventar"] = $sql->fetch_assoc();
		
		$sql = $this->mySQLcon->query("SELECT * FROM coins WHERE Name='".$this->mySQLcon->escape_string($this->Name)."'");
		if ($sql->num_rows == 0) {
			$this->mySQLcon->query("INSERT INTO coins (Name, Coins, txn, psc) VALUES ('".$this->mySQLcon->escape_string($this->Name)."', '0', '', '')");
		}
		$sql = $this->mySQLcon->query("SELECT * FROM coins WHERE Name='".$this->mySQLcon->escape_string($this->Name)."'");
		$arr["coins"] = $sql->fetch_assoc();
		
		return $arr;
	}
	
	private function isInGameLoggedin() {
		$ingame = false;
		
		$whereFIX = "Name='".$this->mySQLcon->escape_string($this->Name)."'";
		if (SCRIPT_TYPE == 'ultimate') {
			$whereFIX = "UID='".$this->mySQLcon->escape_string($this->UID)."'";
		}
		$sql = $this->mySQLcon->query("SELECT * FROM loggedin WHERE ".$whereFIX);
		while ($row = $sql->fetch_assoc()) {
			$loggedin = $row['Loggedin'];
			if ($loggedin == "1") {
				$ingame = true;
			}
		}
		return $ingame;
	}
	
	private function checkPlayerVIP() {
		//if ($this->Admin) { return (365*99); }
		$whereFIX = "Name='".$this->mySQLcon->escape_string($this->Name)."'";
		if (SCRIPT_TYPE == 'ultimate') {
			$whereFIX = "UID='".$this->mySQLcon->escape_string($this->UID)."'";
		}
		$sql = $this->mySQLcon->query("SELECT * FROM bonustable WHERE ".$whereFIX);
		$row = $sql->fetch_assoc();
	
		$yearDay = date("z")+1;
		$year = date("Y");
		$premDay = $row['PremiumUntilDay'];
		$premYear = $row['PremiumUntilYear'];
		if ($premYear == 0) { $premYear = $year; } 
		
		$days = ($premYear-$year)*365+($premDay-$yearDay);
		
		return (($days > 0) ? $days : 0);
	}
	
	// Public functions
	public function takePlayerCoins($coins, $reason) {
		$this->Coins = $this->Coins - $coins;
		$this->mySQLcon->query("UPDATE coins SET Coins='".$this->Coins."' WHERE Name='".$this->mySQLcon->escape_string($this->Name)."'");
		$log = @file_get_contents("logs/coins.log");
		file_put_contents("logs/coins.log", $log."[".date("d-m-Y, H:i:s")."]: (TAKE ".$coins." Coins) ".$reason."\n");
	}
	
	// Info: Query eventuell anpassen! Struktur mit deiner DB vergleichen!
	public function changePlayerName($oldname, $newname) {
		if ($this->Loggedin) {
			if ($oldname == $this->Name) {
				if ($this->inGameLoggedin == true) {
					return false;
				}
			} else {
				$whereFIX = "Name='".$this->mySQLcon->escape_string($this->Name)."'";
				if (SCRIPT_TYPE == 'ultimate') {
					$whereFIX = "UID='".$this->mySQLcon->escape_string($this->UID)."'";
				}
				$sql = $this->mySQLcon->query("SELECT * FROM loggedin WHERE ".$whereFIX);
				while ($row = $sql->fetch_assoc()) {
					$loggedin = $row['Loggedin'];
					if ($loggedin == "1") {
						return false;
					}
				}
			}
			
			$oldname = $this->mySQLcon->escape_string($oldname);
			$newname = $this->mySQLcon->escape_string($newname);
			
			$this->mySQLcon->multi_query("UPDATE achievments SET Name='$newname' WHERE Name='$oldname';
			UPDATE ban SET Name='$newname' WHERE Name = '$oldname';
			UPDATE ban SET Admin='$newname' WHERE Admin='$oldname';
			UPDATE coins SET Name='$newname' WHERE Name='$oldname';
			UPDATE betakeys SET Name='$newname' WHERE Name='$oldname';
			UPDATE biz SET Inhaber='$newname' WHERE Inhaber='$oldname';
			UPDATE blacklist SET Name='$newname' WHERE Name = '$oldname';
			UPDATE blocks SET Name='$newname' WHERE Name='$oldname';
			UPDATE bonustable SET Name='$newname' WHERE Name='$oldname';
			UPDATE buyit SET Anbieter='$newname' WHERE Anbieter='$oldname';
			UPDATE buyit SET Hoechstbietender='$newname' WHERE Hoechstbietender='$oldname';
			UPDATE gang_members SET Name='$newname' WHERE Name='$oldname';
			UPDATE gang_members SET Founder='$newname' WHERE Founder='$oldname';
			UPDATE gunlicense SET Name='$newname' WHERE Name='$oldname';
			UPDATE houses SET Besitzer='$newname' WHERE Besitzer='$oldname';
			UPDATE inventar SET Name='$newname' WHERE Name='$oldname';
			UPDATE loggedin SET Name='$newname' WHERE Name='$oldname';
			UPDATE logout SET Name='$newname' WHERE Name='$oldname';
			UPDATE lotto SET name='$newname' WHERE name='$oldname';
			UPDATE object SET placer='$newname' WHERE placer='$oldname';
			UPDATE packages SET Name='$newname' WHERE Name='$oldname';
			UPDATE players SET Name='$newname' WHERE Name='$oldname';
			UPDATE playingtime SET Name='$newname' WHERE Name='$oldname';
			UPDATE pm SET Sender='$newname' WHERE Sender='$oldname';
			UPDATE pm SET Empfaenger='$newname' WHERE Empfaenger = '$oldname';
			UPDATE prestige SET Besitzer='$newname' WHERE Besitzer='$oldname';
			UPDATE racing SET Name='$newname' WHERE Name='$oldname';
			UPDATE skills SET Name='$newname' WHERE Name='$oldname';
			UPDATE state_files SET name='$newname' WHERE name = '$oldname';
			UPDATE support SET player='$newname' WHERE player='$oldname';
			UPDATE tickets SET name='$newname' WHERE name='$oldname';
			UPDATE ticket_answeres SET name='$newname' WHERE name='$oldname';
			UPDATE ticket_answeres SET admin='$newname' WHERE admin='$oldname';
			UPDATE userdata SET Name='$newname' WHERE Name='$oldname';
			UPDATE vehicles SET Besitzer='$newname' WHERE Besitzer='$oldname';
			UPDATE warns SET player='$newname' WHERE player = '$oldname';
			UPDATE warns SET admin='$newname' WHERE admin='$oldname';
			UPDATE weed SET name='$newname' WHERE name='$oldname'");
			
			return true;
		}
	}
	
	
	public function getNameFromUID($uid) {
		$sql = $this->mySQLcon->query("SELECT * FROM players WHERE UID='".$uid."';");
		$row = $sql->fetch_assoc();
		return $row['Name'];
	}
	
}
?>