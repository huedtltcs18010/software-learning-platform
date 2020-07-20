#!/bin/bash

LOG_FILE="/var/www/aplus/pops/storage/logs/deploy.log"
echo $(date +"%Y-%m-%d %H:%M:%S") >> $LOG_FILE
/usr/bin/git pull origin master >> $LOG_FILE
echo "" >> $LOG_FILE
