FROM webplates/php:5.6-fpm-node-6.3
# node sass does not support Alpine at the moment
# https://github.com/sass/node-sass/issues/1589

RUN set -xe \
    && apt-get update \
    && apt-get install -qqy git libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12-dev libicu-dev unzip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) iconv mbstring mcrypt intl pdo_mysql gd zip

ENV BOWER_VERSION=1.7.9 GULP_VERSION=1.2.2 NPM_CONFIG_LOGLEVEL=warn
ENV COMPOSER_VERSION=1.1.0 COMPOSER_ALLOW_SUPERUSER=1
ENV SYMFONY_ENV prod

WORKDIR /app

RUN set -xe \
    && npm install --silent -g bower@$BOWER_VERSION gulp-cli@$GULP_VERSION \
    && echo "[PHP]\n\ndate.timezone = UTC" > /usr/local/etc/php/php.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} \
    && composer global require --quiet "hirak/prestissimo:^0.3"

# Install frontend dependencies
COPY package.json npm-shrinkwrap.json ./
RUN npm install --silent

COPY bower.json .
RUN bower --allow-root install

COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-interaction --quiet --no-autoloader --no-scripts

COPY . .

# Build and cleanup
RUN set -xe \
    && composer dump-autoload --optimize \
    && composer run-script post-install-cmd \
    && gulp --env production \
    && bin/console assets:install \
    && mv web/ public/ \
    && bin/console cache:clear --no-warmup \
    && rm -rf .babelrc \
        bower_components/ \
        bower.json \
        etc/ \
        gulpfile.babel.js \
        node_modules/ \
        npm-shrinkwrap.json \
        package.json \
        var/cache/* \
        var/logs/* \
    && mkdir -p var/sessions/ var/uploads/ \
    && chmod -R 777 var/sessions/ var/uploads/

VOLUME ["/app/web", "/app/var/sessions", "/app/var/uploads", "/app/var/media", "/app/var/search"]

COPY etc/docker/prod/app/entrypoint.sh /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]

# Production PHP configuration
COPY etc/docker/prod/app/php.ini /usr/local/etc/php/php.ini

ENV SYMFONY__SULU_MEDIA__FORMAT_CACHE__PATH %kernel.root_dir%/../var/uploads/media
