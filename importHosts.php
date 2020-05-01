<?php

// Set these Variables - XG Firewall
$usernameXG = "USER" ; 
$pwXG = "PW";
$apiVersion = "VERSION";
$apiXG = "https://XG-IP:XG-PORT/webconsole/APIController?reqxml=";


// Read Host File in HOST:IP format
$hosts = file_get_contents('hosts.txt');


// +++++++++++++++++++ Process Data +++++++++++++++++++

// Create API Login - head
$head = $apiXG . '<Request APIVersion="' . $apiVersion . '"><Login><Username>' . $usernameXG . '</Username><Password passwordform="plain">' . $pwXG . '</Password></Login>'; 

processHosts($head,"hosts.txt", "host.curl"); 


// +++++++++++++++++++ Function Definitions +++++++++++++++++++


/**
 * processHosts() 
 * Processes the a File with format HOST:IP\nHOST:IP 
 * 
 * Params: 
 * $head -> XML Head
 * $inFile -> File to Read from
 * $outfile -> Filename for Output
 * 
*/
function processHosts($head, $inFile, $outfile) {

	$outFile = fopen($outfile, "w"); 
	$file = fopen($inFile, "r");

	if ($file) {
		while (($line = fgets($file)) !== false) {

			$arr = explode(":",$line);
			$req = $head .'<Set operation="add">';
			$req .= '<IPHost><Name>' . $arr[0] . '</Name><HostType>IP</HostType><IPAddress>'.	trim($arr[1]) . '</IPAddress></IPHost>' ;
			$req .= "</Set></Request>"; 
			$req .= "\n";
			fwrite($outFile,$req); 
		}

	} else {
		die("error opening file.");
	} 
	
	fclose($file);
	fclose($outFile);
}

?>