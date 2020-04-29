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

4. Parse output to CURL and migrate the Services: 

curl.sh: 
```
while read x 
do
  curl -k -I $x
done 
```

```
cat *.xml | bash curl.sh
```
