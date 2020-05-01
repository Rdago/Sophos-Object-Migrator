# Sophos Object Migrator

## SG2XG.php:
Migrates UTM Objects in curlable Format for XG API.

This little Script reads Host and Service Objects from the Sophos UTM Firewall API and parses them to a curlable Format in order to add Objects to the Sophos XG Firewall. It Could be automated even more with curling the Items directly into the Sophos XG Firewall. In some cases you may want to modify some names with Search/Replace, thats why XML-Files will be created in first place.


### Usage: 

1. Set UTM IP,PORT + Token Variables in the Skript

2. Set XG Username / PW / Version and API URl

3. Execute Script like "php SG2XG.php"


## Hosts2XG.php:
Converts a Colon-seperated List of Objects into a curlable Format for XG API.

This little Script reads Hosts in "HOST:IP" Format and parses them to a curlable Format in order to add Objects to the Sophos XG Firewall. It Could be automated even more with curling the Items directly into the Sophos XG Firewall. In some cases you may want to modify some names with Search/Replace, thats why XML-Files will be created in first place.


### Usage: 

1. Put the hosts.txt File into your working directory

2. Set XG Username / PW / Version and API URl

3. Execute Script like "php Hosts2XG.php"


## Tips & Tricks 

I personally Curl everything into my XG Firewall by using the curl.sh Skript like this: 

```bash
cat *.xml | bash curl.sh
```
