#!/usr/bin/env bash

# Exit the script if any statement returns a non-true return value
set -e

/etc/init.d/cron stop

echo "Cron is stopped"
