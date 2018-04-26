<?php
/*************************************************
***** Copyright (c) FirstOne Media 2014-2018 *****
**************************************************/

function curlGet($url) {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function getSecTime($duration) {
	if (!$duration) {
		$duration = 0;
	}
	
	$year = date("Y") - 1900;
	$day = date("z");
	$hour = date("G");
	$minute = date("i");
	
	$total = $year * 365 * 24 * 60 + $day * 24 * 60 + ( $hour + $duration ) * 60 + $minute;
	
	return $total;
}

$weaponNames = array(0 => "Faust", 1 => "Schlagring", 2 => "Golf Schläger", 3 => "Gummiknüppel", 4 => "Messer", 5 => "Baseball Schläger", 6 => "Schaufel", 7 => "Billard Queue", 8 => "Katana", 9 => "Kettensäge", 22 => "Pistole", 23 => "Schallgedämpfte Pistole", 24 => "Desert Eagle", 25 => "Shotgun", 26 => "Abgesägte Schrotflinte", 27 => "SPAZ-12 Combat Shotgun", 28 => "Uzi", 29 => "MP5", 32 => "TEC-9", 30 => "AK-47", 31 => "M4", 33 => "Country Rifle", 34 => "Sniper Rifle", 35 => "Panzerfaust", 36 => "Wärme suchende Panzerfaust", 37 => "Flammenwerfer", 38 => "Minigun", 16 => "Granaten", 17 => "Tränengaß", 18 => "Molotov Cocktails", 39 => "Rucksackladung", 41 => "Sprühdose", 42 => "Feuerlöscher", 43 => "Kamera", 10 => "Langer lialaner Dildo", 11 => "Kurzer brauner Dildo", 12 => "Vibrator", 14 => "Blumenstrauß", 15 => "Gehstock", 44 => "Nachtsichtgerät", 45 => "Infrarot Brille", 46 => "Fallschirm", 40 => "Zünder für Rucksackladungen");

// Vehicle Names
$vehname = array();
$vehname[602] = 'Alpha';
$vehname[496] = 'Blista Compact';
$vehname[401] = 'Bravura';
$vehname[518] = 'Buccaneer';
$vehname[527] = 'Cadrona';
$vehname[589] = 'Club';
$vehname[419] = 'Esperanto';
$vehname[533] = 'Feltzer';
$vehname[526] = 'Fortune';
$vehname[474] = 'Hermes';
$vehname[545] = 'Hustler';
$vehname[517] = 'Majestic';
$vehname[410] = 'Manana';
$vehname[600] = 'Picador';
$vehname[436] = 'Previon';
$vehname[580] = 'Stafford';
$vehname[439] = 'Stallion';
$vehname[549] = 'Tampa';
$vehname[491] = 'Virgo';
$vehname[445] = 'Admiral';
$vehname[604] = 'Damaged Glendale';
$vehname[507] = 'Elegant';
$vehname[585] = 'Emperor';
$vehname[587] = 'Euros';
$vehname[466] = 'Glendale';
$vehname[492] = 'Greenwood';
$vehname[546] = 'Intruder';
$vehname[551] = 'Merit';
$vehname[516] = 'Nebula';
$vehname[467] = 'Oceanic';
$vehname[426] = 'Premier';
$vehname[547] = 'Primo';
$vehname[405] = 'Sentinel';
$vehname[409] = 'Stretch';
$vehname[550] = 'Sunrise';
$vehname[566] = 'Tahoma';
$vehname[540] = 'Vincent';
$vehname[421] = 'Washington';
$vehname[529] = 'Willard';
$vehname[592] = 'Andromada';
$vehname[577] = 'AT-400';
$vehname[511] = 'Beagle';
$vehname[548] = 'Cargobob';
$vehname[512] = 'Cropduster';
$vehname[593] = 'Dodo';
$vehname[425] = 'Hunter';
$vehname[520] = 'Hydra';
$vehname[417] = 'Leviathan';
$vehname[487] = 'Maverick';
$vehname[553] = 'Nevada';
$vehname[488] = 'News Chopper';
$vehname[497] = 'Police Maverick';
$vehname[563] = 'Raindance';
$vehname[476] = 'Rustler';
$vehname[447] = 'Seasparrow';
$vehname[519] = 'Shamal';
$vehname[460] = 'Skimmer';
$vehname[469] = 'Sparrow';
$vehname[513] = 'Stuntplane';
$vehname[581] = 'BF-400';
$vehname[509] = 'Bike';
$vehname[481] = 'BMX';
$vehname[462] = 'Faggio';
$vehname[521] = 'FCR-900';
$vehname[463] = 'Freeway';
$vehname[510] = 'Mountain Bike';
$vehname[522] = 'NRG-500';
$vehname[461] = 'PCJ-600';
$vehname[448] = 'Pizza Boy';
$vehname[468] = 'Sanchez';
$vehname[586] = 'Wayfarer';
$vehname[472] = 'Coastguard';
$vehname[473] = 'Dinghy';
$vehname[493] = 'Jetmax';
$vehname[595] = 'Launch';
$vehname[484] = 'Marquis';
$vehname[430] = 'Predator';
$vehname[453] = 'Reefer';
$vehname[452] = 'Speeder';
$vehname[446] = 'Squalo';
$vehname[454] = 'Tropic';
$vehname[485] = 'Baggage';
$vehname[552] = 'Utility Van';
$vehname[431] = 'Bus';
$vehname[438] = 'Cabbie';
$vehname[437] = 'Coach';
$vehname[574] = 'Sweeper';
$vehname[420] = 'Taxi';
$vehname[525] = 'Towtruck';
$vehname[408] = 'Trashmaster';
$vehname[416] = 'Ambulance';
$vehname[433] = 'Barracks';
$vehname[427] = 'Enforcer';
$vehname[490] = 'FBI Rancher';
$vehname[528] = 'FBI Truck';
$vehname[407] = 'Fire Truck';
$vehname[544] = 'Fire Truck (Ladder)';
$vehname[523] = 'HPV1000';
$vehname[470] = 'Patriot';
$vehname[598] = 'Police Car (Las Venturas)';
$vehname[596] = 'Police Car (Los Santos)';
$vehname[597] = 'Police Car (San Fierro)';
$vehname[599] = 'Police Ranger';
$vehname[432] = 'Rhino';
$vehname[601] = 'S.W.A.T.';
$vehname[428] = 'Securicar';
$vehname[499] = 'Benson';
$vehname[609] = 'Black Boxville';
$vehname[498] = 'Boxville';
$vehname[524] = 'Cement Truck';
$vehname[532] = 'Combine Harvester';
$vehname[578] = 'DFT-30';
$vehname[486] = 'Dozer';
$vehname[406] = 'Dumper';
$vehname[573] = 'Dune';
$vehname[455] = 'Flatbed';
$vehname[588] = 'Hotdog';
$vehname[403] = 'Linerunner';
$vehname[514] = 'Linerunner (From Tanker Commando)';
$vehname[423] = 'Mr. Whoopee';
$vehname[414] = 'Mule';
$vehname[443] = 'Packer';
$vehname[515] = 'Roadtrain';
$vehname[531] = 'Tractor';
$vehname[456] = 'Yankee';
$vehname[459] = 'Berkleys RC Van';
$vehname[422] = 'Bobcat';
$vehname[482] = 'Burrito';
$vehname[605] = 'Damaged Sadler';
$vehname[530] = 'Forklift';
$vehname[418] = 'Moonbeam';
$vehname[572] = 'Mower';
$vehname[582] = 'News Van';
$vehname[413] = 'Pony';
$vehname[440] = 'Rumpo';
$vehname[543] = 'Sadler';
$vehname[583] = 'Tug';
$vehname[478] = 'Walton';
$vehname[554] = 'Yosemite';
$vehname[536] = 'Blade';
$vehname[575] = 'Broadway';
$vehname[534] = 'Remington';
$vehname[567] = 'Savanna';
$vehname[535] = 'Slamvan';
$vehname[576] = 'Tornado';
$vehname[412] = 'Voodoo';
$vehname[402] = 'Buffalo';
$vehname[542] = 'Clover';
$vehname[603] = 'Phoenix';
$vehname[475] = 'Sabre';
$vehname[449] = 'Tram';
$vehname[537] = 'Freight';
$vehname[538] = 'Brown Streak';
$vehname[570] = 'Brown Streak Carriage';
$vehname[569] = 'Flat Freight';
$vehname[590] = 'Box Freight';
$vehname[441] = 'RC Bandit';
$vehname[464] = 'RC Baron';
$vehname[501] = 'RC Goblin';
$vehname[465] = 'RC Raider';
$vehname[564] = 'RC Tiger';
$vehname[568] = 'Bandito';
$vehname[424] = 'BF Injection';
$vehname[504] = 'Bloodring Banger';
$vehname[457] = 'Caddy';
$vehname[483] = 'Camper';
$vehname[508] = 'Journey';
$vehname[571] = 'Kart';
$vehname[500] = 'Mesa';
$vehname[444] = 'Monster';
$vehname[556] = 'Monster 2';
$vehname[557] = 'Monster 3';
$vehname[471] = 'Quadbike';
$vehname[495] = 'Sandking';
$vehname[539] = 'Vortex';
$vehname[429] = 'Banshee';
$vehname[541] = 'Bullet';
$vehname[415] = 'Cheetah';
$vehname[480] = 'Comet';
$vehname[562] = 'Elegy';
$vehname[565] = 'Flash';
$vehname[434] = 'Hotknife';
$vehname[494] = 'Hotring Racer 1';
$vehname[502] = 'Hotring Racer 3';
$vehname[503] = 'Hotring Racer 2';
$vehname[411] = 'Infernus';
$vehname[559] = 'Jester';
$vehname[561] = 'Stratum';
$vehname[560] = 'Sultan';
$vehname[506] = 'Super GT';
$vehname[451] = 'Turismo';
$vehname[558] = 'Uranus';
$vehname[555] = 'Windsor';
$vehname[477] = 'ZR-350';
$vehname[579] = 'Huntley';
$vehname[400] = 'Landstalker';
$vehname[404] = 'Perennial';
$vehname[489] = 'Rancher';
$vehname[603] = 'Phoenix';
$vehname[505] = 'Rancher (From Lure)';
$vehname[479] = 'Regina';
$vehname[442] = 'Romero';
$vehname[459] = 'Solair';
$vehname[606] = 'Baggage Trailer (covered)';
$vehname[607] = 'Baggage Trailer (Uncovered)';
$vehname[610] = 'Farm Trailer';
$vehname[611] = 'Street Clean Trailer';
$vehname[584] = 'Trailer (From Tanker Commando)';
$vehname[608] = 'Trailer (Stairs)';
$vehname[435] = 'Trailer 1';
$vehname[450] = 'Trailer 2';
$vehname[591] = 'Trailer 3';
$vehname[594] = 'RC Cam (flower pot)';





/*
Arrays sourced from: https://raw.githubusercontent.com/multitheftauto/mtasa-blue/master/Shared/mods/deathmatch/logic/CZoneNames.cpp
*/
$cityList = array(
        array( -2353,  2275,     0, -2153,  2475,   200, "Bayside Marina" ),
        array( -2741,  2175,     0, -2353,  2722,   200, "Bayside" ),
        array( -2741,  1268,     0, -2533,  1490,   200, "Battery Point" ),
        array( -2741,   793,     0, -2533,  1268,   200, "Paradiso" ),
        array( -2741,   458,     0, -2533,   793,   200, "Santa Flora" ),
        array( -2994,   458,     0, -2741,  1339,   200, "Palisades" ),
        array( -2867,   277,     0, -2593,   458,   200, "City Hall" ),
        array( -2994,   277,     0, -2867,   458,   200, "Ocean Flats" ),
        array( -2994,  -222,     0, -2593,   277,   200, "Ocean Flats" ),
        array( -2994,  -430,     0, -2831,  -222,   200, "Ocean Flats" ),
        array( -2270,  -430,     0, -2178,  -324,   200, "Foster Valley" ),
        array( -2178,  -599,     0, -1794,  -324,   200, "Foster Valley" ),
        array( -2593,  -222,     0, -2411,    54,   200, "Hashbury" ),
        array( -2533,   968,     0, -2274,  1358,   200, "Juniper Hollow" ),
        array( -2533,  1358,     0, -1996,  1501,   200, "Esplanade North" ),
        array( -1996,  1358,     0, -1524,  1592,   200, "Esplanade North" ),
        array( -1982,  1274,     0, -1524,  1358,   200, "Esplanade North" ),
        array( -1871,   744,     0, -1701,  1176,   300, "Financial" ),
        array( -2274,   744,     0, -1982,  1358,   200, "Calton Heights" ),
        array( -1982,   744,     0, -1871,  1274,   200, "Downtown" ),
        array( -1871,  1176,     0, -1620,  1274,   200, "Downtown" ),
        array( -1700,   744,     0, -1580,  1176,   200, "Downtown" ),
        array( -1580,   744,     0, -1499,  1025,   200, "Downtown" ),
        array( -2533,   578,     0, -2274,   968,   200, "Juniper Hill" ),
        array( -2274,   578,     0, -2078,   744,   200, "Chinatown" ),
        array( -2078,   578,     0, -1499,   744,   200, "Downtown" ),
        array( -2329,   458,     0, -1993,   578,   200, "King's" ),
        array( -2411,   265,     0, -1993,   373,   200, "King's" ),
        array( -2253,   373,     0, -1993,   458,   200, "King's" ),
        array( -2411,  -222,     0, -2173,   265,   200, "Garcia" ),
        array( -2270,  -324,     0, -1794,  -222,   200, "Doherty" ),
        array( -2173,  -222,     0, -1794,   265,   200, "Doherty" ),
        array( -1993,   265,     0, -1794,   578,   200, "Downtown" ),
        array( -1499,   -50,     0, -1242,   249,   200, "Easter Bay Airport" ),
        array( -1794,   249,     0, -1242,   578,   200, "Easter Basin" ),
        array( -1794,   -50,     0, -1499,   249,   200, "Easter Basin" ),
        array( -1620,  1176,     0, -1580,  1274,   200, "Esplanade East" ),
        array( -1580,  1025,     0, -1499,  1274,   200, "Esplanade East" ),
        array( -1499,   578,   -79, -1339,  1274,    20, "Esplanade East" ),
        array( -2324, -2584,     0, -1964, -2212,   200, "Angel Pine" ),
        array( -1632, -2263,     0, -1601, -2231,   200, "Shady Cabin" ),
        array( -1166, -2641,     0,  -321, -1856,   200, "Back o Beyond" ),
        array( -1166, -1856,     0,  -815, -1602,   200, "Leafy Hollow" ),
        array(  -594, -1648,     0,  -187, -1276,   200, "Flint Range" ),
        array(  -792,  -698,     0,  -452,  -380,   200, "Fallen Tree" ),
        array( -1209, -1317,   114,  -908,  -787,   251, "The Farm" ),
        array( -1645,  2498,     0, -1372,  2777,   200, "El Quebrados" ),
        array( -1372,  2498,     0, -1277,  2615,   200, "Aldea Malvada" ),
        array(  -968,  1929,     0,  -481,  2155,   200, "The Sherman Dam" ),
        array(  -926,  1398,     0,  -719,  1634,   200, "Las Barrancas" ),
        array(  -376,   826,     0,   123,  1220,   200, "Fort Carson" ),
        array(   337,   710,  -115,   860,  1031,   203, "Hunter Quarry" ),
        array(   338,  1228,     0,   664,  1655,   200, "Octane Springs" ),
        array(   176,  1305,     0,   338,  1520,   200, "Green Palms" ),
        array(  -405,  1712,     0,  -276,  1892,   200, "Regular Tom" ),
        array(  -365,  2123,     0,  -208,  2217,   200, "Las Brujas" ),
        array(    37,  2337,     0,   435,  2677,   200, "Verdant Meadows" ),
        array(  -354,  2580,     0,  -133,  2816,   200, "Las Payasadas" ),
        array(  -901,  2221,     0,  -592,  2571,   200, "Arco del Oeste" ),
        array( -1794,  -730,     0, -1213,   -50,   200, "Easter Bay Airport" ),
        array(  2576,    62,     0,  2759,   385,   200, "Hankypanky Point" ),
        array(  2160,  -149,     0,  2576,   228,   200, "Palomino Creek" ),
        array(  2285,  -768,     0,  2770,  -269,   200, "North Rock" ),
        array(  1119,   119,     0,  1451,   493,   200, "Montgomery" ),
        array(  1451,   347,     0,  1582,   420,   200, "Montgomery" ),
        array(   603,   264,     0,   761,   366,   200, "Hampton Barns" ),
        array(   508,  -139,     0,  1306,   119,   200, "Fern Ridge" ),
        array(   580,  -674,     0,   861,  -404,   200, "Dillimore" ),
        array(   967,  -450,     0,  1176,  -217,   200, "Hilltop Farm" ),
        array(   104,  -220,     0,   349,   152,   200, "Blueberry" ),
        array(    19,  -404,     0,   349,  -220,   200, "Blueberry" ),
        array(  -947,  -304,     0,  -319,   327,   200, "The Panopticon" ),
        array(  2759,   296,     0,  2774,   594,   200, "Frederick Bridge" ),
        array(  1664,   401,     0,  1785,   567,   200, "The Mako Span" ),
        array(  -319,  -220,     0,   104,   293,   200, "Blueberry Acres" ),
        array(  -222,   293,     0,  -122,   476,   200, "Martin Bridge" ),
        array(   434,   366,     0,   603,   555,   200, "Fallow Bridge" ),
        array( -1820, -2643,     0, -1226, -1771,   200, "Shady Creeks" ),
        array( -2030, -2174,     0, -1820, -1771,   200, "Shady Creeks" ),
        array( -2533,   458,     0, -2329,   578,   200, "Queens" ),
        array( -2593,    54,     0, -2411,   458,   200, "Queens" ),
        array( -2411,   373,     0, -2253,   458,   200, "Queens" ),
        array(  -480,   596,  -242,   869,  2993,   900, "Bone County" ),
        array( -2741,  1659,     0, -2616,  2175,   200, "Gant Bridge" ),
        array( -2741,  1490,     0, -2616,  1659,   200, "Gant Bridge" ),
        array( -1132,  -768,     0,  -956,  -578,   200, "Easter Bay Chemicals" ),
        array( -1132,  -787,     0,  -956,  -768,   200, "Easter Bay Chemicals" ),
        array( -1213,  -730,     0, -1132,   -50,   200, "Easter Bay Airport" ),
        array( -2178, -1115,     0, -1794,  -599,   200, "Foster Valley" ),
        array( -2178, -1250,     0, -1794, -1115,   200, "Foster Valley" ),
        array( -1242,   -50,     0, -1213,   578,   200, "Easter Bay Airport" ),
        array( -1213,   -50,     0,  -947,   578,   200, "Easter Bay Airport" ),
        array(  1249, -2394,   -89,  1852, -2179,   110, "Los Santos International" ),
        array(  1852, -2394,   -89,  2089, -2179,   110, "Los Santos International" ),
        array(   930, -2488,   -89,  1249, -2006,   110, "Verdant Bluffs" ),
        array(  1812, -2179,   -89,  1970, -1852,   110, "El Corona" ),
        array(  1970, -2179,   -89,  2089, -1852,   110, "Willowfield" ),
        array(  2089, -2235,   -89,  2201, -1989,   110, "Willowfield" ),
        array(  2089, -1989,   -89,  2324, -1852,   110, "Willowfield" ),
        array(  2201, -2095,   -89,  2324, -1989,   110, "Willowfield" ),
        array(  2373, -2697,   -89,  2809, -2330,   110, "Ocean Docks" ),
        array(  2201, -2418,   -89,  2324, -2095,   110, "Ocean Docks" ),
        array(   647, -1804,   -89,   851, -1577,   110, "Marina" ),
        array(   647, -2173,   -89,   930, -1804,   110, "Verona Beach" ),
        array(   930, -2006,   -89,  1073, -1804,   110, "Verona Beach" ),
        array(  1073, -2006,   -89,  1249, -1842,   110, "Verdant Bluffs" ),
        array(  1249, -2179,   -89,  1692, -1842,   110, "Verdant Bluffs" ),
        array(  1692, -2179,   -89,  1812, -1842,   110, "El Corona" ),
        array(   851, -1804,   -89,  1046, -1577,   110, "Verona Beach" ),
        array(   647, -1577,   -89,   807, -1416,   110, "Marina" ),
        array(   807, -1577,   -89,   926, -1416,   110, "Marina" ),
        array(  1161, -1722,   -89,  1323, -1577,   110, "Verona Beach" ),
        array(  1046, -1722,   -89,  1161, -1577,   110, "Verona Beach" ),
        array(  1046, -1804,   -89,  1323, -1722,   110, "Conference Center" ),
        array(  1073, -1842,   -89,  1323, -1804,   110, "Conference Center" ),
        array(  1323, -1842,   -89,  1701, -1722,   110, "Commerce" ),
        array(  1323, -1722,   -89,  1440, -1577,   110, "Commerce" ),
        array(  1370, -1577,   -89,  1463, -1384,   110, "Commerce" ),
        array(  1463, -1577,   -89,  1667, -1430,   110, "Commerce" ),
        array(  1440, -1722,   -89,  1583, -1577,   110, "Pershing Square" ),
        array(  1583, -1722,   -89,  1758, -1577,   110, "Commerce" ),
        array(  1701, -1842,   -89,  1812, -1722,   110, "Little Mexico" ),
        array(  1758, -1722,   -89,  1812, -1577,   110, "Little Mexico" ),
        array(  1667, -1577,   -89,  1812, -1430,   110, "Commerce" ),
        array(  1812, -1852,   -89,  1971, -1742,   110, "Idlewood" ),
        array(  1812, -1742,   -89,  1951, -1602,   110, "Idlewood" ),
        array(  1951, -1742,   -89,  2124, -1602,   110, "Idlewood" ),
        array(  1812, -1602,   -89,  2124, -1449,   110, "Idlewood" ),
        array(  2124, -1742,   -89,  2222, -1494,   110, "Idlewood" ),
        array(  1812, -1449,   -89,  1996, -1350,   110, "Glen Park" ),
        array(  1812, -1100,   -89,  1994,  -973,   110, "Glen Park" ),
        array(  1996, -1449,   -89,  2056, -1350,   110, "Jefferson" ),
        array(  2124, -1494,   -89,  2266, -1449,   110, "Jefferson" ),
        array(  2056, -1372,   -89,  2281, -1210,   110, "Jefferson" ),
        array(  2056, -1210,   -89,  2185, -1126,   110, "Jefferson" ),
        array(  2185, -1210,   -89,  2281, -1154,   110, "Jefferson" ),
        array(  1994, -1100,   -89,  2056,  -920,   110, "Las Colinas" ),
        array(  2056, -1126,   -89,  2126,  -920,   110, "Las Colinas" ),
        array(  2185, -1154,   -89,  2281,  -934,   110, "Las Colinas" ),
        array(  2126, -1126,   -89,  2185,  -934,   110, "Las Colinas" ),
        array(  1971, -1852,   -89,  2222, -1742,   110, "Idlewood" ),
        array(  2222, -1852,   -89,  2632, -1722,   110, "Ganton" ),
        array(  2222, -1722,   -89,  2632, -1628,   110, "Ganton" ),
        array(  2541, -1941,   -89,  2703, -1852,   110, "Willowfield" ),
        array(  2632, -1852,   -89,  2959, -1668,   110, "East Beach" ),
        array(  2632, -1668,   -89,  2747, -1393,   110, "East Beach" ),
        array(  2747, -1668,   -89,  2959, -1498,   110, "East Beach" ),
        array(  2421, -1628,   -89,  2632, -1454,   110, "East Los Santos" ),
        array(  2222, -1628,   -89,  2421, -1494,   110, "East Los Santos" ),
        array(  2056, -1449,   -89,  2266, -1372,   110, "Jefferson" ),
        array(  2266, -1494,   -89,  2381, -1372,   110, "East Los Santos" ),
        array(  2381, -1494,   -89,  2421, -1454,   110, "East Los Santos" ),
        array(  2281, -1372,   -89,  2381, -1135,   110, "East Los Santos" ),
        array(  2381, -1454,   -89,  2462, -1135,   110, "East Los Santos" ),
        array(  2462, -1454,   -89,  2581, -1135,   110, "East Los Santos" ),
        array(  2581, -1454,   -89,  2632, -1393,   110, "Los Flores" ),
        array(  2581, -1393,   -89,  2747, -1135,   110, "Los Flores" ),
        array(  2747, -1498,   -89,  2959, -1120,   110, "East Beach" ),
        array(  2747, -1120,   -89,  2959,  -945,   110, "Las Colinas" ),
        array(  2632, -1135,   -89,  2747,  -945,   110, "Las Colinas" ),
        array(  2281, -1135,   -89,  2632,  -945,   110, "Las Colinas" ),
        array(  1463, -1430,   -89,  1724, -1290,   110, "Downtown Los Santos" ),
        array(  1724, -1430,   -89,  1812, -1250,   110, "Downtown Los Santos" ),
        array(  1463, -1290,   -89,  1724, -1150,   110, "Downtown Los Santos" ),
        array(  1370, -1384,   -89,  1463, -1170,   110, "Downtown Los Santos" ),
        array(  1724, -1250,   -89,  1812, -1150,   110, "Downtown Los Santos" ),
        array(  1463, -1150,   -89,  1812,  -768,   110, "Mulholland Intersection" ),
        array(  1414,  -768,   -89,  1667,  -452,   110, "Mulholland" ),
        array(  1281,  -452,   -89,  1641,  -290,   110, "Mulholland" ),
        array(  1269,  -768,   -89,  1414,  -452,   110, "Mulholland" ),
        array(   787, -1416,   -89,  1072, -1310,   110, "Market" ),
        array(   787, -1310,   -89,   952, -1130,   110, "Vinewood" ),
        array(   952, -1310,   -89,  1072, -1130,   110, "Market" ),
        array(  1370, -1170,   -89,  1463, -1130,   110, "Downtown Los Santos" ),
        array(  1378, -1130,   -89,  1463, -1026,   110, "Downtown Los Santos" ),
        array(  1391, -1026,   -89,  1463,  -926,   110, "Downtown Los Santos" ),
        array(  1252, -1130,   -89,  1378, -1026,   110, "Temple" ),
        array(  1252, -1026,   -89,  1391,  -926,   110, "Temple" ),
        array(  1252,  -926,   -89,  1357,  -910,   110, "Temple" ),
        array(  1357,  -926,   -89,  1463,  -768,   110, "Mulholland" ),
        array(  1318,  -910,   -89,  1357,  -768,   110, "Mulholland" ),
        array(  1169,  -910,   -89,  1318,  -768,   110, "Mulholland" ),
        array(   787, -1130,   -89,   952,  -954,   110, "Vinewood" ),
        array(   952, -1130,   -89,  1096,  -937,   110, "Temple" ),
        array(  1096, -1130,   -89,  1252, -1026,   110, "Temple" ),
        array(  1096, -1026,   -89,  1252,  -910,   110, "Temple" ),
        array(   768,  -954,   -89,   952,  -860,   110, "Mulholland" ),
        array(   687,  -860,   -89,   911,  -768,   110, "Mulholland" ),
        array(   737,  -768,   -89,  1142,  -674,   110, "Mulholland" ),
        array(  1096,  -910,   -89,  1169,  -768,   110, "Mulholland" ),
        array(   952,  -937,   -89,  1096,  -860,   110, "Mulholland" ),
        array(   911,  -860,   -89,  1096,  -768,   110, "Mulholland" ),
        array(   861,  -674,   -89,  1156,  -600,   110, "Mulholland" ),
        array(   342, -2173,   -89,   647, -1684,   110, "Santa Maria Beach" ),
        array(    72, -2173,   -89,   342, -1684,   110, "Santa Maria Beach" ),
        array(    72, -1684,   -89,   225, -1544,   110, "Rodeo" ),
        array(    72, -1544,   -89,   225, -1404,   110, "Rodeo" ),
        array(   225, -1684,   -89,   312, -1501,   110, "Rodeo" ),
        array(   225, -1501,   -89,   334, -1369,   110, "Rodeo" ),
        array(   334, -1501,   -89,   422, -1406,   110, "Rodeo" ),
        array(   312, -1684,   -89,   422, -1501,   110, "Rodeo" ),
        array(   422, -1684,   -89,   558, -1570,   110, "Rodeo" ),
        array(   558, -1684,   -89,   647, -1384,   110, "Rodeo" ),
        array(   466, -1570,   -89,   558, -1385,   110, "Rodeo" ),
        array(   422, -1570,   -89,   466, -1406,   110, "Rodeo" ),
        array(   647, -1227,   -89,   787, -1118,   110, "Vinewood" ),
        array(   647, -1118,   -89,   787,  -954,   110, "Richman" ),
        array(   647,  -954,   -89,   768,  -860,   110, "Richman" ),
        array(   466, -1385,   -89,   647, -1235,   110, "Rodeo" ),
        array(   334, -1406,   -89,   466, -1292,   110, "Rodeo" ),
        array(   225, -1369,   -89,   334, -1292,   110, "Richman" ),
        array(   225, -1292,   -89,   466, -1235,   110, "Richman" ),
        array(    72, -1404,   -89,   225, -1235,   110, "Richman" ),
        array(    72, -1235,   -89,   321, -1008,   110, "Richman" ),
        array(   321, -1235,   -89,   647, -1044,   110, "Richman" ),
        array(   321, -1044,   -89,   647,  -860,   110, "Richman" ),
        array(   321,  -860,   -89,   687,  -768,   110, "Richman" ),
        array(   321,  -768,   -89,   700,  -674,   110, "Richman" ),
        array(  2027,   863,   -89,  2087,  1703,   110, "The Strip" ),
        array(  2106,  1863,   -89,  2162,  2202,   110, "The Strip" ),
        array(  1817,   863,   -89,  2027,  1083,   110, "The Four Dragons Casino" ),
        array(  1817,  1083,   -89,  2027,  1283,   110, "The Pink Swan" ),
        array(  1817,  1283,   -89,  2027,  1469,   110, "The High Roller" ),
        array(  1817,  1469,   -89,  2027,  1703,   110, "Pirates in Men's Pants" ),
        array(  1817,  1863,   -89,  2106,  2011,   110, "The Visage" ),
        array(  1817,  1703,   -89,  2027,  1863,   110, "The Visage" ),
        array(  1457,   823,   -89,  2377,   863,   110, "Julius Thruway South" ),
        array(  1197,  1163,   -89,  1236,  2243,   110, "Julius Thruway West" ),
        array(  2377,   788,   -89,  2537,   897,   110, "Julius Thruway South" ),
        array(  2537,   676,   -89,  2902,   943,   110, "Rockshore East" ),
        array(  2087,   943,   -89,  2623,  1203,   110, "Come-A-Lot" ),
        array(  2087,  1203,   -89,  2640,  1383,   110, "The Camel's Toe" ),
        array(  2087,  1383,   -89,  2437,  1543,   110, "Royal Casino" ),
        array(  2087,  1543,   -89,  2437,  1703,   110, "Caligula's Palace" ),
        array(  2137,  1703,   -89,  2437,  1783,   110, "Caligula's Palace" ),
        array(  2437,  1383,   -89,  2624,  1783,   110, "Pilgrim" ),
        array(  2437,  1783,   -89,  2685,  2012,   110, "Starfish Casino" ),
        array(  2027,  1783,   -89,  2162,  1863,   110, "The Strip" ),
        array(  2027,  1703,   -89,  2137,  1783,   110, "The Strip" ),
        array(  2011,  2202,   -89,  2237,  2508,   110, "The Emerald Isle" ),
        array(  2162,  2012,   -89,  2685,  2202,   110, "Old Venturas Strip" ),
        array(  2498,  2626,   -89,  2749,  2861,   110, "K.A.C.C. Military Fuels" ),
        array(  2749,  1937,   -89,  2921,  2669,   110, "Creek" ),
        array(  2749,  1548,   -89,  2923,  1937,   110, "Sobell Rail Yards" ),
        array(  2749,  1198,   -89,  2923,  1548,   110, "Linden Station" ),
        array(  2623,   943,   -89,  2749,  1055,   110, "Julius Thruway East" ),
        array(  2749,   943,   -89,  2923,  1198,   110, "Linden Side" ),
        array(  2685,  1055,   -89,  2749,  2626,   110, "Julius Thruway East" ),
        array(  2498,  2542,   -89,  2685,  2626,   110, "Julius Thruway North" ),
        array(  2536,  2442,   -89,  2685,  2542,   110, "Julius Thruway East" ),
        array(  2625,  2202,   -89,  2685,  2442,   110, "Julius Thruway East" ),
        array(  2237,  2542,   -89,  2498,  2663,   110, "Julius Thruway North" ),
        array(  2121,  2508,   -89,  2237,  2663,   110, "Julius Thruway North" ),
        array(  1938,  2508,   -89,  2121,  2624,   110, "Julius Thruway North" ),
        array(  1534,  2433,   -89,  1848,  2583,   110, "Julius Thruway North" ),
        array(  1236,  2142,   -89,  1297,  2243,   110, "Julius Thruway West" ),
        array(  1848,  2478,   -89,  1938,  2553,   110, "Julius Thruway North" ),
        array(  1777,   863,   -89,  1817,  2342,   110, "Harry Gold Parkway" ),
        array(  1817,  2011,   -89,  2106,  2202,   110, "Redsands East" ),
        array(  1817,  2202,   -89,  2011,  2342,   110, "Redsands East" ),
        array(  1848,  2342,   -89,  2011,  2478,   110, "Redsands East" ),
        array(  1704,  2342,   -89,  1848,  2433,   110, "Julius Thruway North" ),
        array(  1236,  1883,   -89,  1777,  2142,   110, "Redsands West" ),
        array(  1297,  2142,   -89,  1777,  2243,   110, "Redsands West" ),
        array(  1377,  2243,   -89,  1704,  2433,   110, "Redsands West" ),
        array(  1704,  2243,   -89,  1777,  2342,   110, "Redsands West" ),
        array(  1236,  1203,   -89,  1457,  1883,   110, "Las Venturas Airport" ),
        array(  1457,  1203,   -89,  1777,  1883,   110, "Las Venturas Airport" ),
        array(  1457,  1143,   -89,  1777,  1203,   110, "Las Venturas Airport" ),
        array(  1457,   863,   -89,  1777,  1143,   110, "LVA Freight Depot" ),
        array(  1197,  1044,   -89,  1277,  1163,   110, "Blackfield Intersection" ),
        array(  1166,   795,   -89,  1375,  1044,   110, "Blackfield Intersection" ),
        array(  1277,  1044,   -89,  1315,  1087,   110, "Blackfield Intersection" ),
        array(  1375,   823,   -89,  1457,   919,   110, "Blackfield Intersection" ),
        array(  1375,   919,   -89,  1457,  1203,   110, "LVA Freight Depot" ),
        array(  1277,  1087,   -89,  1375,  1203,   110, "LVA Freight Depot" ),
        array(  1315,  1044,   -89,  1375,  1087,   110, "LVA Freight Depot" ),
        array(  1236,  1163,   -89,  1277,  1203,   110, "LVA Freight Depot" ),
        array(   964,  1044,   -89,  1197,  1203,   110, "Greenglass College" ),
        array(   964,   930,   -89,  1166,  1044,   110, "Greenglass College" ),
        array(   964,  1203,   -89,  1197,  1403,   110, "Blackfield" ),
        array(   964,  1403,   -89,  1197,  1726,   110, "Blackfield" ),
        array(  2237,  2202,   -89,  2536,  2542,   110, "Roca Escalante" ),
        array(  2536,  2202,   -89,  2625,  2442,   110, "Roca Escalante" ),
        array(  1823,   596,   -89,  1997,   823,   110, "Last Dime Motel" ),
        array(  1997,   596,   -89,  2377,   823,   110, "Rockshore West" ),
        array(  2377,   596,   -89,  2537,   788,   110, "Rockshore West" ),
        array(  1558,   596,   -89,  1823,   823,   110, "Randolph Industrial Estate" ),
        array(  1375,   596,   -89,  1558,   823,   110, "Blackfield Chapel" ),
        array(  1325,   596,   -89,  1375,   795,   110, "Blackfield Chapel" ),
        array(  1377,  2433,   -89,  1534,  2507,   110, "Julius Thruway North" ),
        array(  1098,  2243,   -89,  1377,  2507,   110, "Pilson Intersection" ),
        array(   883,  1726,   -89,  1098,  2507,   110, "Whitewood Estates" ),
        array(  1534,  2583,   -89,  1848,  2863,   110, "Prickle Pine" ),
        array(  1117,  2507,   -89,  1534,  2723,   110, "Prickle Pine" ),
        array(  1848,  2553,   -89,  1938,  2863,   110, "Prickle Pine" ),
        array(  2121,  2663,   -89,  2498,  2861,   110, "Spinybed" ),
        array(  1938,  2624,   -89,  2121,  2861,   110, "Prickle Pine" ),
        array(  2624,  1383,   -89,  2685,  1783,   110, "Pilgrim" ),
        array(  2450,   385,  -100,  2759,   562,   200, "San Andreas Sound" ),
        array(  1916,  -233,  -100,  2131,    13,   200, "Fisher's Lagoon" ),
        array( -1339,   828,   -89, -1213,  1057,   110, "Garver Bridge" ),
        array( -1213,   950,   -89, -1087,  1178,   110, "Garver Bridge" ),
        array( -1499,   696,  -179, -1339,   925,    20, "Garver Bridge" ),
        array( -1339,   599,   -89, -1213,   828,   110, "Kincaid Bridge" ),
        array( -1213,   721,   -89, -1087,   950,   110, "Kincaid Bridge" ),
        array( -1087,   855,   -89,  -961,   986,   110, "Kincaid Bridge" ),
        array(  -321, -2224,   -89,    44, -1724,   110, "Los Santos Inlet" ),
        array(  -789,  1659,   -89,  -599,  1929,   110, "Sherman Reservoir" ),
        array(  -314,  -753,   -89,  -106,  -463,   110, "Flint Water" ),
        array( -1709,  -833,     0, -1446,  -730,   200, "Easter Tunnel" ),
        array( -2290,  2548,   -89, -1950,  2723,   110, "Bayside Tunnel" ),
        array(  -410,  1403,     0,  -137,  1681,   200, "'The Big Ear'" ),
        array(   -90,  1286,     0,   153,  1554,   200, "Lil' Probe Inn" ),
        array(  -936,  2611,     0,  -715,  2847,   200, "Valle Ocultado" ),
        array(  1812, -1350,   -89,  2056, -1100,   110, "Glen Park" ),
        array(  2324, -2302,   -89,  2703, -2145,   110, "Ocean Docks" ),
        array(  2811,  1229,   -39,  2861,  1407,    60, "Linden Station" ),
        array(  1692, -1971,   -20,  1812, -1932,    79, "Unity Station" ),
        array(   647, -1416,   -89,   787, -1227,   110, "Vinewood" ),
        array(   787, -1410,   -34,   866, -1310,    65, "Market Station" ),
        array( -2007,    56,     0, -1922,   224,   100, "Cranberry Station" ),
        array(  1377,  2600,   -21,  1492,  2687,    78, "Yellow Bell Station" ),
        array( -2616,  1501,     0, -1996,  1659,   200, "San Fierro Bay" ),
        array( -2616,  1659,     0, -1996,  2175,   200, "San Fierro Bay" ),
        array(  -464,  2217,     0,  -208,  2580,   200, "El Castillo del Diablo" ),
        array(  -208,  2123,     0,   114,  2337,   200, "El Castillo del Diablo" ),
        array(  -208,  2337,     0,     8,  2487,   200, "El Castillo del Diablo" ),
        array(   -91,  1655,   -50,   421,  2123,   250, "Restricted Area" ),
        array(  1546,   208,     0,  1745,   347,   200, "Montgomery Intersection" ),
        array(  1582,   347,     0,  1664,   401,   200, "Montgomery Intersection" ),
        array( -1119,  1178,   -89,  -862,  1351,   110, "Robada Intersection" ),
        array(  -187, -1596,   -89,    17, -1276,   110, "Flint Intersection" ),
        array( -1315,  -405,    15, -1264,  -209,    25, "Easter Bay Airport" ),
        array( -1354,  -287,    15, -1315,  -209,    25, "Easter Bay Airport" ),
        array( -1490,  -209,    15, -1264,  -148,    25, "Easter Bay Airport" ),
        array(  1072, -1416,   -89,  1370, -1130,   110, "Market" ),
        array(   926, -1577,   -89,  1370, -1416,   110, "Market" ),
        array( -2646,  -355,     0, -2270,  -222,   200, "Avispa Country Club" ),
        array( -2831,  -430,     0, -2646,  -222,   200, "Avispa Country Club" ),
        array( -2994,  -811,     0, -2178,  -430,   200, "Missionary Hill" ),
        array( -2178, -1771,   -47, -1936, -1250,   576, "Mount Chiliad" ),
        array( -2997, -1115,   -47, -2178,  -971,   576, "Mount Chiliad" ),
        array( -2994, -2189,   -47, -2178, -1115,   576, "Mount Chiliad" ),
        array( -2178, -2189,   -47, -2030, -1771,   576, "Mount Chiliad" ),
        array(  1117,  2723,   -89,  1457,  2863,   110, "Yellow Bell Golf Course" ),
        array(  1457,  2723,   -89,  1534,  2863,   110, "Yellow Bell Golf Course" ),
        array(  1515,  1586,   -12,  1729,  1714,    87, "Las Venturas Airport" ),
        array(  2089, -2394,   -89,  2201, -2235,   110, "Ocean Docks" ),
        array(  1382, -2730,   -89,  2201, -2394,   110, "Los Santos International" ),
        array(  2201, -2730,   -89,  2324, -2418,   110, "Ocean Docks" ),
        array(  1974, -2394,   -39,  2089, -2256,    60, "Los Santos International" ),
        array(  1400, -2669,   -39,  2189, -2597,    60, "Los Santos International" ),
        array(  2051, -2597,   -39,  2152, -2394,    60, "Los Santos International" ),
        array(  2437,  1858,   -39,  2495,  1970,    60, "Starfish Casino" ),
        array(  -399, -1075,    -1,  -319,  -977,   198, "Beacon Hill" ),
        array( -2361,  -417,     0, -2270,  -355,   200, "Avispa Country Club" ),
        array( -2667,  -302,   -28, -2646,  -262,    71, "Avispa Country Club" ),
        array( -2395,  -222,     0, -2354,  -204,   200, "Garcia" ),
        array( -2470,  -355,     0, -2270,  -318,    46, "Avispa Country Club" ),
        array( -2550,  -355,     0, -2470,  -318,    39, "Avispa Country Club" ),
        array(  2703, -2126,   -89,  2959, -1852,   110, "Playa del Seville" ),
        array(  2703, -2302,   -89,  2959, -2126,   110, "Ocean Docks" ),
        array(  2162,  1883,   -89,  2437,  2012,   110, "Starfish Casino" ),
        array(  2162,  1783,   -89,  2437,  1883,   110, "The Clown's Pocket" ),
        array(  2324, -2145,   -89,  2703, -2059,   110, "Ocean Docks" ),
        array(  2324, -2059,   -89,  2541, -1852,   110, "Willowfield" ),
        array(  2541, -2059,   -89,  2703, -1941,   110, "Willowfield" ),
        array(  1098,  1726,   -89,  1197,  2243,   110, "Whitewood Estates" ),
		
		array( -2997, -1115,  -242, -1213,  1659,   900, "San Fierro" ),
		array( -2997,  1659,  -242,  -480,  2993,   900, "Tierra Robada" ),
        array( -1213,   596,  -242,  -480,  1659,   900, "Tierra Robada" ),
		array(   869,   596,  -242,  2997,  2993,   900, "Las Venturas" ),
		array( -1213,  -768,  -242,  2997,   596,   900, "Red County" ),
		array( -2997, -2892,  -242, -1213, -1115,   900, "Whetstone" ),
		array( -1213, -2892,  -242,    44,  -768,   900, "Flint County" ),
		array(    44, -2892,  -242,  2997,  -768,   900, "Los Santos" ),
);
$countryList = array(
		array( -2997, -1115,  -242, -1213,  1659,   900, "San Fierro" ),
		array( -2997,  1659,  -242,  -480,  2993,   900, "Tierra Robada" ),
        array( -1213,   596,  -242,  -480,  1659,   900, "Tierra Robada" ),
		array(   869,   596,  -242,  2997,  2993,   900, "Las Venturas" ),
		array( -1213,  -768,  -242,  2997,   596,   900, "Red County" ),
		array( -2997, -2892,  -242, -1213, -1115,   900, "Whetstone" ),
		array( -1213, -2892,  -242,    44,  -768,   900, "Flint County" ),
		array(    44, -2892,  -242,  2997,  -768,   900, "Los Santos" ),
);

function getZoneName($x, $y, $z, $co=false) {
	global $cityList, $countryList;
	
	$list = $cityList;
	if ($co == true) {
		$list = $countryList;
	}
	
	foreach ($list as $i => $arr) {
		if (($x >= $arr[0] && $x <= $arr[3]) || ($x <= $arr[0] && $x >= $arr[3])) {
			if (($y >= $arr[1] && $y <= $arr[4]) || ($y <= $arr[1] && $y >= $arr[4])) {
				//if (($z >= $arr[2] && $z <= $arr[5]) || ($z <= $arr[2] && $z >= $arr[5])) {
					return $arr[6];
				//}
			}
		}
	}
	
	return "Unknown";
}
?>