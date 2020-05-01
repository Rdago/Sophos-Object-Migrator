#!/bin/bash

while read x 
do 
    RESPONSE=curl -s -k -o /dev/null -w "%{http_code}" $x
    if [[ $RESPONSE -eq 200 ]]
    then
        echo -e "\e[32m[+] Object created.\e[0m" 
    else 
        echo -e "\e[31m[-] An Error occured Processing this Item.\e[0m"
    fi
done
