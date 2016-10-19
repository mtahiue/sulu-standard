FROM webplates/symfony-php-dev:7.0-fpm

ARG USE_XDEBUG=no

RUN if [ $USE_XDEBUG = "yes" ]; then docker-php-ext-enable xdebug; fi

RUN set -xe \
    && mkdir -p /usr/src/ffmpeg \
    && cd /usr/src/ffmpeg \
    && curl -kfSL https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-32bit-static.tar.xz -o ffmpeg.tar.xz \
    && tar xf ffmpeg.tar.xz \
    && mv ffmpeg-3.1.4-32bit-static/ff* /usr/local/bin/ \
    && cd \
    && rm -rf /usr/src/ffmpeg

COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY entrypoint.sh /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]
