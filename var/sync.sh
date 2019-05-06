#!/bin/bash
TDIR="/var/www/html/backup"
cd $TDIR

echo "Sync directory: $TDIR"
/usr/bin/svn update .
echo "Commit changes"
/usr/bin/svn add --force .
echo "Finish?"
/usr/bin/svn ci -m "Sync" .
