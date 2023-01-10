#!/bin/bash
if [ "$1" == 'skipone' ];
then
echo "Skipping stage 1";
else
echo "Starting setup website ssl CA"
mkdir -p ssl/{crl,crt,csr,key,ncrt}
cd ssl
read -p "Enter serial number from 0 to 1000: " serial
echo "$serial">serial
touch index.txt
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
SALT=$(cat /dev/urandom | tr -dc '[:alpha:]' | fold -w ${1:-55} | head -n 1)
if [ "$SALT" -z ];
then
    SALT='sECsl0sWaAk50MxKHEyWRtuCoI4SDcDuL0nuN2XahD7xa3WeLFQwG2CPyYUeBo0YFtCU3wddB08eMdtB'
fi;
export CC CITY LOCALITY ONAME UNIT EMAIL PWD dir SALT
cat $opensslconf | envsubst > openssl.cnf
openssl genrsa -out cakey.pem 4096
openssl req -new -x509 -key cakey.pem -out cacert.pem -days 3650 --config=openssl.cnf
cd ..
echo "Copying php configuration"
cat init.php.template | envsubst > config/init.php
#echo "Installing php"
#apt install -y php php-curl
fi;
if [ "$1" == 'skipsecond' ];
then
echo "Skipping personal setup";
else
echo "Starting setup personal cert CA"
mkdir -p pssl/{crl,crt,csr,key,ncrt}
cd pssl
read -p "Enter serial number from 0 to 1000: " serial
echo "$serial">serial
touch index.txt
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
fi;
echo "Starting example server"
php -S 0.0.0.0:7783 -t .

# openssl req -new -newkey rsa:4096 -nodes -keyout key/client01.key -config openssl.cnf -out csr/client01.csr  -subj "/C=Russia/ST=Moscow/L=Moscow/O=MyCorp/OU=Unit/CN=himan/emailAddress=mail@email.co"
