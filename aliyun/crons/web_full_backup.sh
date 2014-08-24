#!/bin/bash

DATE=$(date +%Y%m%d)
WEB_FILE=web_all_${DATE}

cd /data/backup/www/
tar zcvf ${WEB_FILE}.tar.gz /data/www
