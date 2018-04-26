<?php
define('APP_KEY', 'xDrQwHDpfzICAzjtMAxZKJA13d23OKQV'); // \at\paysafecard\android\common\p014d\p015a\p051b\az.java:74 "rest.paysafecard.com"

function pscCurl($uri, $headers=false) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_USERAGENT, "paysafecard/1613 CFNetwork/711.4.6 Darwin/14.0.0");
	
	$head = array('Accept: application/json', 'Accept-Language: de-de');
	if ($headers != false) {
		$head = array_merge($head, $headers);
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
	
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$dataWithHeader = curl_exec($ch);
	curl_close($ch);
	
	return array("info" => $info, "data" => $data, "dataHeader" => $dataWithHeader);
}

function checkPaysafecardPIN($pin) {
	$pin = str_replace('-', '', $pin);
	
	return array("success" => false, "errorCode" => 0, "errorMsg" => "Deaktiviert! IP wird nach einigen anfragen von der Paysafecard API gesperrt.", "pin" => $pin);
	
	/*$RET = array("success" => true, "errorCode" => 0, "errorMsg" => "", "pin" => $pin);
	
	$threatMetrixIdentifier = md5(rand(1000, 9999999));
	
	$API = pscCurl("https://rest.paysafecard.com/rest/card/pin?clientApplicationKey=".APP_KEY."&threatMetrixIdentifier=".$threatMetrixIdentifier, array('CardPin: '.$pin));
	$data = json_decode($API['data'], true);
		
	if (!isset($data['errorCode']) || empty($data['errorCode'])) {
		$RET = array_merge($RET, $data);
		$RET['used'] = false;
		if ($RET['reservedBalance'] != 0 || $RET['availableBalance'] != $RET['faceValue']) {
			$RET['used'] = true;
		}
		
	} else {
		$RET['success'] = false;
		$RET['errorCode'] = $data['errorCode'];
		$RET['errorMsg'] = $data['message'];
	}
	
	if (isset($data['serialNumber']) && !empty($data['serialNumber'])) {
		preg_match("/AuthToken: (.*)/", $API['dataHeader'], $authToken);
		preg_match("/Set-Cookie: (.*);/", $API['dataHeader'], $cookie);
		
		$API2 = pscCurl("https://rest.paysafecard.com/rest/card/".$data['serialNumber']."/transactions?clientApplicationKey=".APP_KEY."&threatMetrixIdentifier=".$threatMetrixIdentifier, array('AuthToken: '.$authToken[1], 'Cookie: '.$cookie[1].';'));
		$RET['transactions'] = json_decode($API2['data'], true)['transactions'];
	}
	return $RET;*/
}

/*
error codes:
20003 	= card locked
7852	= mypsc-lock
*/
?>