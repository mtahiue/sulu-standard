#!/bin/sh

set -e

bin/console cache:clear -c admin
bin/console cache:clear -c website
chmod -R 777 var/cache/ var/logs/
cp -r public/* web/

case "$1" in
    "php-fpm")
        exec php-fpm ;;
    "")
        exec php-fpm ;;
    "migrate")
        exec bin/console doctrine:migrations:migrate ;;
    *)
        exec "$@" ;;
esac
