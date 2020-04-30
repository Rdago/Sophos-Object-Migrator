# UTM2XG_Object_Migration
Migrates UTM Objects in Curlable Format for XG API.

This little Script reads Host and Service Objects from the Sophos UTM Firewall API and parses them to a curlable Format in order to add Objects to the Sophos XG Firewall. It Could be automated even more with curling the Items directly into the Sophos XG Firewall. In some cases you may want to modify some names with Search/Replace, thats why XML-Files will be created in first place.


## Usage: 

1. Set UTM IP,PORT + Token Variables

2. Set XG Username / PW / Version and API URl

3. Execute Script like "php UTM2XG_obj_migr.php"

4. Parse output to CURL and start the Migration:

```bash
cat *.xml | bash curl.sh
```
