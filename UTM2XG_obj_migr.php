<?php

// Set these Variables
$username = "USER" ; 
$pw = "PW";
$apiVersion = "VERSION";
$apiURI = "https://XG-IP:XG-PORT/webconsole/APIController?reqxml=";

// Create API Login - head
$head = $apiURI . '<Request APIVersion="' . $apiVersion . '"><Login><Username>' . $username . '</Username><Password passwordform="plain">' . $pw . '</Password></Login>'; 


// +++++++++++++++++++ Read Files +++++++++++++++++++

// Read Network Hosts files https://<UTM>/api/objects/network/hosts
$hosts = file_get_contents('network.hosts');
$hosts_data = json_decode($hosts,true);

// Read DNS Hosts Files https://<UTM>/api/objects/network/dns_host/
$dns = file_get_contents('network.dns');
$dns_data = json_decode($dns,true);

// Read UDP Services Files https://<UTM>/api/objects/service/udp/
$sudp = file_get_contents('service.udp');
$sudp_data = json_decode($sudp,true);

// Read TCP Services Hosts Files https://<UTM>/api/objects/service/tcp/
$stcp = file_get_contents('service.tcp');
$stcp_data = json_decode($stcp,true);

// Read Service Group Hosts Files https://<UTM>/api/objects/service/group/
$sgrp = file_get_contents('service.group');
$sgrp_data = json_decode($sgrp,true);



// +++++++++++++++++++ Process Data +++++++++++++++++++

processHosts($head,$hosts_data,"hosts.xml"); 
processDNS($head, $dns_data, "dns.xml");
processServ($head,$stcp_data, "tcp.xml");
processServ($head,$sudp_data, "udp.xml");



// +++++++++++++++++++ Function Definitions +++++++++++++++++++


/**
 * processHosts() 
 * Processes the decoded JSON Array and writes it as xml to file.
 * 
 * Params: 
 * $head -> XML Head
 * $hosts_data -> decoded JSON array
 * $outfile -> Filename for Output
 * 
*/
function processHosts($head, $hosts_data, $outfile) {

	$file = fopen($outfile, "w"); 

	foreach ($hosts_data as $key => $value1) {

		// IP Host with Hostname => FQDN Hosts 
		if ($hosts_data[$key]["_type"] == "network/host" && isset($hosts_data[$key]["hostnames"][0]) ) {
			$req = $head .'<Set operation="add">';
			$req .= '<FQDNHost><Name>' . $hosts_data[$key]["name"] . '</Name><FQDN>'. $hosts_data[$key]["hostnames"][0] . '</FQDN></FQDNHost>';
			$req .= "</Set></Request>"; 
			$req .= "\n";
			fwrite($file,$req); 
		}
		
		// IP Hosts without DNS => IP Host
		if ($hosts_data[$key]["_type"] == "network/host" && !isset($hosts_data[$key]["hostnames"][0]) ) {
			$req = $head .'<Set operation="add">';
			$req .= '<IPHost><Name>' . $hosts_data[$key]["name"] . '</Name><HostType>IP</HostType><IPAddress>'.	$hosts_data[$key]["address"] . '</IPAddress></IPHost>' ;
			$req .= "</Set></Request>"; 
			$req .= "\n";
			fwrite($file,$req); 
		}
	}

	fclose($file);
}


/**
 * processDNS() 
 * Processes the decoded JSON Array and writes it as xml to file.
 * 
 * Params: 
 * $head -> XML Head
 * $dns_data -> decoded JSON array
 * $outfile -> Filename for Output
 * 
*/
function processDNS($head, $dns_data, $outfile) {

	$file = fopen($outfile, "w"); 
	foreach ($dns_data as $key => $value1) {

		// DNS Hosts => FQDN Hosts 
		if ($dns_data[$key]["_type"] == "network/dns_host") {
			$req = $head .'<Set operation="add">';
			$req .= '<FQDNHost><Name>' . $dns_data[$key]["name"] . '</Name><FQDN>'. $dns_data[$key]["hostname"] . '</FQDN></FQDNHost>';
			$req .= "</Set></Request>"; 
			$req .= "\n";
			fwrite($file,$req); 
		}
	}
	fclose($file);

}


/**
 * processServices() 
 * Processes the decoded JSON Array and writes it as xml to file.
 * 
 * Params: 
 * $head -> XML Head
 * $serv_data -> decoded JSON array
 * $outfile -> Filename for Output
 * 
*/
function processServ($head, $serv_data, $outfile) {

	$file = fopen($outfile, "w"); 
	foreach ($serv_data as $key => $value1) {

		// TCP Ports => Service
		if ($serv_data[$key]["_type"] == "service/tcp" ) {
			$req = $head .'<Set operation="add">';
			$req .= '<Services><Name>' . $serv_data[$key]["name"] . '</Name>';
			$req .= '<Type>TCPorUDP</Type>' . 
					'<ServiceDetails><ServiceDetail>' . 
					'<Protocol>TCP</Protocol>';
			$req .=	'<SourcePort>' . $serv_data[$key]["src_low"] . ':' . $serv_data[$key]["src_high"]  . '</SourcePort>' .
					'<DestinationPort>' . $serv_data[$key]["dst_low"]. ':' . $serv_data[$key]["dst_high"] . '</DestinationPort>';
			$req .= '</ServiceDetail></ServiceDetails></Services>';
			$req .= "</Set></Request>"; 
			$req .= "\n";
			fwrite($file,$req); 
		}

		// UDP Ports => Service
		if ($serv_data[$key]["_type"] == "service/udp" ) {
			$req = $head .'<Set operation="add">';
			$req .= '<Services><Name>' . $serv_data[$key]["name"] . '</Name>';
			$req .= '<Type>TCPorUDP</Type>' . 
					'<ServiceDetails><ServiceDetail>' . 
					'<Protocol>UDP</Protocol>';
			$req .=	'<SourcePort>' . $serv_data[$key]["src_low"] . ':' . $serv_data[$key]["src_high"]  . '</SourcePort>' . 
					'<DestinationPort>' . $serv_data[$key]["dst_low"]. ':' . $serv_data[$key]["dst_high"] . '</DestinationPort>';
			$req .= '</ServiceDetail></ServiceDetails></Services>';
			$req .= "</Set></Request>"; 
			$req .= "\n";
			fwrite($file,$req); 
		}
	}
	
	fclose($file);

}

?>
