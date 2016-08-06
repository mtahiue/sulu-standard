#!/bin/sh

set -e

bin/console cache:clear -c admin
bin/console cache:clear -c website
chmod -R 777 var/cache/ var/logs/
cp -r public/* web/
mkdir -p var/media/storage/ var/media/cache/

case "$1" in
    "php-fpm")
        exec php-fpm ;;
    "")
        exec php-fpm ;;
    "console")
        exec "bin/$@" ;;
    *)
        echo "Unallowed command"
        exit 1
        ;;
esac
