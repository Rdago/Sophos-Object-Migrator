#!/bin/bash

while read x 
do 
    curl -k -I $x
done
