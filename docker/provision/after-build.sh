#!/usr/bin/env bash

# Exit the script if any statement returns a non-true return value
set -e

apt autoremove -y 2&>1 >/dev/null || true
apt clean -y 2&>1 >/dev/null || true
apt autoclean -y 2&>1 >/dev/null || true

rm -rf \
	/var/www/storage/framework/views/* \
	/var/www/storage/app/public/* \
	/var/www/storage/logs/* \
	/var/www/storage/framework/cache/* \
	/var/lib/apt/lists/* \
	/tmp/* \
	/var/tmp/* \
	/var/cache \
	/etc/nginx/sites-enabled/default \
	/etc/nginx/conf.d/nginx_status_location \
	/usr/lib/php/20121212 \
	/usr/lib/php/20131226 \
	/entypoint.sh

find /var/log -type f | while read f; do
	echo -ne '' > ${f} 2&>1 > /dev/null || true;
done

# The for loop throws an error in case of absence file.
# Thus we'll use if-condition here.
# Note: We don't use recursive search .
if [ -z "$(find /entrypoint.d -maxdepth 1 -type f  -name \"*.sh\" 2>/dev/null)" ]; then
    for file in /entrypoint.d/*.sh; do
    	chmod +x ${file} || true;
    done
fi

mkdir -p /var/cache/apt

if [ -f /var/www/.env ]; then
	rm -f /var/www/.env
fi

exit 0
