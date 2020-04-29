<<<<<<< HEAD
# UTM2XG_Object_Migration
Migrates UTM Objects in Curlable Format for XG
=======
# UTM2XG_Object_Migration
Migrates UTM Objects in Curlable Format for XG API 


## Usage: 

1. Get Data from SG UTM: 
  * https://<UTM>/api/objects/network/hosts
  * https://<UTM>/api/objects/network/dns_host/
  * https://<UTM>/api/objects/service/udp/
  * https://<UTM>/api/objects/service/tcp/
  

2. Modify Variables for Username / PW / Version and API URl of the XG Firewall 

3. Execute Script

4. Parse output to CURL and start the Migration.

cat *.xml | bash curl.sh

>>>>>>> be3598e327c2214e978e983f7a7ebe8b7cc1f691
