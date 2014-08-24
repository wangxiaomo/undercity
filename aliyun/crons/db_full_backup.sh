#!/bin/bash

DATE=$(date +%Y%m%d)
DB_FILE=db_all_${DATE}

cd /data/backup/mysql/
/usr/local/mysql/bin/mysqldump --user=root --password=Yqkzcs123654 --lock-all-tables --all-databases > backup.sql
tar zcvf ${DB_FILE}.tar.gz backup.sql
