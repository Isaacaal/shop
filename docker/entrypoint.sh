#!/bin/sh
set -e

mkdir -p /var/www/var
chown -R www-data:www-data /var/www/var
chmod -R 775 /var/www/var

exec apache2-foreground
