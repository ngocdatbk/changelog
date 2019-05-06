#!/bin/bash

if [ $# -ne 2 ]
then
	echo "Bad syntax. Use /import.sh {dbname} {target}"
	exit 0
else
	mysql -u root -p $1 < /var/www/html/backup/$1.$2.sql
fi
