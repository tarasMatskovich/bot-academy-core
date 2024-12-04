#!/usr/bin/env bash

# Exit the script if any statement returns a non-true return value
set -e

/etc/init.d/cron start
cp -R /var/www/docker/cron/* /etc/cron.d/crontab
chmod -R +x /etc/cron.d/crontab
crontab /etc/cron.d/crontab
/etc/init.d/cron reload

echo "Cron is set up"
