#!/bin/bash

cd /data/logs
find . -ctime +20 | xargs rm -rf

cd /data/backup
find . -ctime +20 | xargs rm -rf
