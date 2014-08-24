#!/bin/bash

DATE=$(date +%Y%m%d)
DB_NAME=wechat_orders
DB_FILE=${DB_NAME}_${DATE}

cd /data/backup/mysql/
/usr/local/mysql/bin/mysqldump --user=root --password=Yqkzcs123654 ${DB_NAME}> ${DB_NAME}.sql
tar zcvf ${DB_FILE}.tar.gz ${DB_NAME}.sql
