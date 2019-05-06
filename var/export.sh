#!/bin/bash

if [ $# -ne 2 ]
then

	echo "Bad syntax. Use ./export.sh {dbname} {target}"
	exit 0

else
	mysqldump -u root -p $1 > /var/www/html/backup/$1.$2.sql
fi
