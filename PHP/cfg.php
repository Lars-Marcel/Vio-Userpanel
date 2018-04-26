<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/
/***
Version: 2.4
***/

/*
	Allgemeine Einstellungen
*/
define('WEBSITE_TITLE',			'Example-RL User Panel'); // Wird im Titel des Browserfensters angezigt.
define('SERVER_NAME',			'Example-RL'); // Wird im CP oben Links angezeigt.
define('DEBUG',					true); // PHP Fehler anzeigen
define('SCRIPT_TYPE',			'extended'); // lite, extended, thc, ultimate
define('IMPRINT_LINK',			''); // Link zum Impressum
$bannedAllowedPages = array("settings", "support", "403", "404", "logout"); // Seiten welche gebannte Spieler aufrufen dürfen.


/*
	Coin Settings
*/
define('USE_COINS',				true); // Die Coin-Funktion de- oder Aktivieren.
define('COIN_WERT',				0.50); // Wert in Euro. 
define('COINS_GIVE_AWAY',		true); // Coins an andere Spieler verschenken.
define('COINS_USE_PAYSAFE',		true); // Paysafe-Zahlung de- oder Aktivieren.
define('COINS_USE_PAYPAL',		true); // PayPal-Zahlung de- oder Aktivieren.
define('PAYPAL_USE_SANDBOX',	true); // Siehe Anleitung im Ordner "Einrichtung des PayPal Button"
define('PAYPAL_EMAIL',			'paypal-facilitator@xyz.de'); // Hier muss die Haupt E-Mail des Accounts rein!

define('COINS_SELL_PREMIUM',	true); // Premium Mitgliedschaft Verkauf
$premiumPrices = array(7 => 4, 30 => 12, 180 => 45, 365 => 60, "Lifetime" => 100); // Tage und Coins lassen sich beliebig anpassen!

define('COINS_SELL_MONEY', true); // inGame-Geld für Coins
$moneyPrices = array(1000 => 1, 10000 => 2, 100000 => 3, 1000000 => 4, 10000000 => 5); // Geld und Coins lassen sich beliebig anpassen!

// Coins: Fahrzeuge
// Vehicle-ID => Coin-Anzahl
$premiumCars = array(451 => 2,
560 => 2,
562 => 2,
565 => 2,
559 => 2,
561 => 2,
494 => 2,
502 => 2,
503 => 2,
434 => 2,
558 => 2,
534 => 1,
576 => 1,
504 => 2,
571 => 2,
495 => 2,
);

// Coins: Skins
// Skin-ID => Coin-Anzahl
define('COINS_SELL_SKINS', true); // Skins verkaufen An/Aus
$coinSkins = array(
264 => 1,
167 => 2,
178 => 1,
152 => 1,
);


/* Marktplatz */
define('MARKTPLATZ_ENABLE',		true); // Marktplatz An / Aus
define('MARKTPLATZ_OFFER_DAYS', '999'); // Dauer in Tagen der Anzeigen


/* Fraktionen */
$factions = array(
0 => array("name" => "-",			"rgb" => "200,200,200"),
1 => array("name" => "S.F.P.D",		"rgb" => "20,150,0"),
2 => array("name" => "Mafia",		"rgb" => "50,50,50"),
3 => array("name" => "Triaden",		"rgb" => "20,50,100"),
4 => array("name" => "Terroristen", "rgb" => "125,0,0"),
5 => array("name" => "Reporter",	"rgb" => "180,130,0"),
6 => array("name" => "F.B.I",		"rgb" => "125,125,200"),
7 => array("name" => "Los Aztecas", "rgb" => "150,150,0"),
8 => array("name" => "Army",		"rgb" => "0,255,0"),
9 => array("name" => "Biker",		"rgb" => "100,50,50")
);


$LogNames			= array(
	"admin"			=> "Admin",
	"allround"		=> "Allround",
	"anticheat"		=> "Anticheat",
	"casino"		=> "Casino",
	"death"			=> "Death",
	"dmg"			=> "Damage",
	"house"			=> "House",
	"kill"			=> "Kill",
	"outsource"		=> "Outsource",
	"pwchange"		=> "PW Change",
	"weed"			=> "Weed",
);
$LogNamesUltimate	= array(
	1 => "allround",
	2 => "admin",
	3 => "damage",
	4 => "Heilung",
	5 => "Chat",
	6 => "aktion",
	7 => "Armor",
	8 => "autodelete",
	9 => "b-Chat",
	10=> "casino",
	11=> "death",
	12=> "dmg",
	13=> "drogen",
	14=> "explodecar",
	15=> "fguns / fkasse",
	16=> "gangwar",
	17=> "Geld",
	18=> "house",
	19=> "kill",
	20=> "pwchange",
	21=> "sellcar / vehicle",
	22=> "tazer",
	23=> "Team-Chat",
	24=> "weed",
	25=> "werbung",
);


/*
	MySQL Daten des Reallife Script
*/
$mySQLcon = new mysqli("localhost", "root", "pass", "ultimate", 3306);
@$mySQLcon->query("set names 'utf8'");

/*
	MTA-SERVER
	
	WICHTIG:
	Folgende Änderung in der mtaserver.conf vornehmen:
    Bei http_dos_exclude und auth_serial_http_ip_exceptions die IP-Adresse des Webservers eintragen.
	Bsp.: <http_dos_exclude>8.8.8.8</http_dos_exclude> <auth_serial_http_ip_exceptions>8.8.8.8</auth_serial_http_ip_exceptions>
*/
define('MTA_IP',			'IP');
define('MTA_PORT',			'22003');
define('MTA_HTTP_PORT',		'22005');
define('MTA_USER',			'User'); // Account benötigt Admin-Rechte!
define('MTA_PASS',			'Passwort');
define('MTA_RESOURCE_NAME', 'vio'); // Name der Reallife resource



/*
	TS3-Server (nur nötig falls Synchronisation genutzt wird)
*/
define('USE_TS3_SYNCHRONISATION', true); // TS3-Synchronisation De- / Aktivieren
$ts3Server = array(
	"tsip"					=> "localhost",
	"tsport"				=> "9987",
	"ts_query_admin"		=> "serveradmin",
	"ts_query_password"		=> "Passwort",
	"ts_query_port"			=> "10011",
	"ts_query_user_nick"	=> "Userpanel" // Name des Query-User welcher dem Spieler angezeigt wird. OHNE LEERZEICHEN!
);

/*
	Hier sind die Gruppen einzutragen welche synchronisiert werden sollen.
	Möglich ist folgendes:
	
	team-[Adminrang]		-> Wenn Teammitglied mit angegebenen Rang erhält der User die entsprechende Gruppe.
	faction-[Fraktions-ID]	-> Sofern der User in einer Fraktion ist, wird er automatisch der Fraktions-Gruppe im TS zugewiesen.
	leader					-> Sofern Leader einer Fraktion, kann eine Leader-Gruppe zugewiesen werden (z.B. für Move/ Kick-Rechte)
	premium					-> Sofern der User eine Aktive Premium-Mitgliedschaft hat, wird er der angegebenen Gruppe zugewiesen.
	activated 				-> User wird Freigeschaltet-Gruppe zugewiesen. (z.B. Guests verbieten auf dem TS Aktionen auszuführen - dann 						können nur Freigeschaltete User Channels joinen etc.)
	
	Bsp.:
	"activated" => 2,
	"premium" => 3,
	"faction-1" => 8,
	"leader" => 5,
	"team-1" => 4,
*/
define('LEADER_RANG', '5'); // Rang des Leader Posten
$groupsToSync = array(
	"team-4"		=> 11,
	"faction-1"		=> 10,
	"premium"		=> 12,
	"leader"		=> 13,
	"activated"		=> 14
);




/*
	Seitentitel
*/
$pagetitles = Array();
$pagetitles["login"]				= "Login";
$pagetitles["home"]					= "Übersicht";
$pagetitles["vehicles"]				= "Fahrzeuge";
$pagetitles["faction"]				= "Fraktion";
$pagetitles["inventory"]			= "Inventar / Waffenbox";
$pagetitles["house"]				= "Haus";
$pagetitles["support"]				= "Support";
$pagetitles["rang"]					= "Ranglisten";
$pagetitles["coins"]				= "Coins";
$pagetitles["settings"]				= "Einstellungen";
$pagetitles["marktplatz"]			= "Marktplatz";
$pagetitles["admin-bans"]			= "Admin: Bans";
$pagetitles["admin-checkplayer"]	= "Admin: Spieler Checken";
$pagetitles["admin-logs"]			= "Admin: Logs";
$pagetitles["admin-players"]		= "Admin: Spieler";
$pagetitles["admin-support"]		= "Admin: Tickets";
$pagetitles["admin-userdata"]		= "Admin: Userdaten bearbeiten";




/*
	Includes
*/
include("usefull.php");
include("mta_sdk.php");
include("ts3php/libraries/TeamSpeak3/TeamSpeak3.php");
include("pscCheck.php");
include("cp.class.php");
?>