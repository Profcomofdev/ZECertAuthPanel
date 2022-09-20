#!/bin/bash
mkdir -p ssl/{crl,crt,csr,key,ncrt}
cd ssl
read -p "Enter serial number from 0 to 1000: " serial
echo "$serial">serial
echo "">index.txt
opensslconf=../openssl.cnf.temp
template=$(cat "$opensslconf")
echo "Enter openssl configuration details:"
read -p "Country Name (2 letter code): " CC
read -p "State or Province Name (full name): " CITY
read -p "Locality Name: " LOCALITY
read -p "Organization Name (eg, company): " ONAME
read -p "Organizational Unit Name (eg, section): " UNIT
read -p "Email Address: " EMAIL
PWD=$(pwd)
dir=$(pwd)
export CC CITY LOCALITY ONAME UNIT EMAIL PWD dir
cat $opensslconf | envsubst > openssl.cnf
openssl genrsa -out cakey.pem 4096
openssl req -new -x509 -key cakey.pem -out cacert.pem -days 3650 --config=openssl.cnf
cd ..
echo "Copying php configuration"
cat init.php.template | envsubst > config/init.php
echo "Installing php"
apt install -y php php-curl
echo "Starting example server"
php -S 0.0.0.0:7783 -t .

