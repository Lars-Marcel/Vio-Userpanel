<?php
include("../cfg.php");

define("LOG_FILE", "../logs/paypal.log");

//if ($_POST) {
	$paypalmode = '';
	if (PAYPAL_USE_SANDBOX==true) {
		$paypalmode = '.sandbox';
	}
	
	$req = 'cmd=' . urlencode('_notify-validate');
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://ipnpb'.$paypalmode.'.paypal.com/cgi-bin/webscr');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www'.$paypalmode.'.sandbox.paypal.com', 'User-Agent: Example-Reallife'));
	$res = curl_exec($ch);
	$err = curl_errno($ch);
	curl_close($ch);
	
	if (strcmp($res, "VERIFIED") == 0) {
		$fix = "Valid";
		
		$transaction_id = $_POST['txn_id'];
		$payerid = $_POST['payer_id'];
		$item_name = $_POST['item_name'];
		$firstname = $_POST['first_name'];
		$lastname = $_POST['last_name'];
		$payeremail = $_POST['payer_email'];
		$receiver_email = $_POST['receiver_email'];
		$paymentdate = date('Y-m-d h:i:s',strtotime($_POST['payment_date']));
		$paymentstatus = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$quantity = $_POST['quantity'];
		$custom = $_POST['custom'];
		
		if ($item_name == "Coins") {
			$price = $quantity * COIN_WERT;
			if ($paymentstatus == "Completed" && $receiver_email == PAYPAL_EMAIL && $payment_currency == "EUR" && (int)$payment_amount >= (int)$price) {
				// Okay
				$sql = $mySQLcon->query("SELECT * FROM players WHERE Name LIKE '".$mySQLcon->escape_string($custom)."'");
				if ($sql->num_rows > 0) {
					$sql = $mySQLcon->query("SELECT * FROM coins WHERE Name LIKE '".$mySQLcon->escape_string($custom)."'");
					if ($sql->num_rows == 0) {
						$mySQLcon->query("INSERT INTO coins (Name, Coins, txn) VALUES ('".$mySQLcon->escape_string($custom)."', '0', '')");
					}
					$sql = $mySQLcon->query("SELECT * FROM coins WHERE Name LIKE '".$mySQLcon->escape_string($custom)."'");
					$row = $sql->fetch_assoc($sql);
					//$coins = $row['Coins'] + $quantity;
					$txn = $transaction_id."|".$row['txn'];
					
					if (strpos($row['txn'], $transaction_id) === false) {
						$mySQLcon->query("UPDATE coins SET Coins=Coins+".$mySQLcon->escape_string($quantity).", txn='".$mySQLcon->escape_string($txn)."' WHERE Name LIKE '".$mySQLcon->escape_string($custom)."'");
						
						error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
						
						$log = @file_get_contents("../logs/coins.log");
						file_put_contents("../logs/coins.log", $log."[".date("d-m-Y, H:i:s")."]: (GIVE ".$quantity." Coins) PayPal-Kauf, Spieler: ".$custom."\n");
						
						exit;
					} else {
						$fix = "Invalid (TXN bereits eingetragen)";
					}
				} else {
					$fix = "Invalid (Player existiert nicht)";
				}
			}
		}
		
		error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req" . PHP_EOL, 3, LOG_FILE);
		
	} else if (strcmp ($res, "INVALID") == 0) {
		$fix = "Invalid";
	} else {
		$fix = "Unknown";
	}
//}

if ($fix != "Valid") {
	mail(PAYPAL_EMAIL, "Paypal Coin Error", $req, PAYPAL_EMAIL);
}
error_log(date('[Y-m-d H:i e] ').$fix." IPN: $req" . PHP_EOL, 3, LOG_FILE);
?>