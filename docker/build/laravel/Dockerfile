FROM php:7.4-fpm-alpine
WORKDIR "/application"

###
# Install additional PHP extensions required for laravel
###
RUN docker-php-source extract && \
  apk add --update --no-cache autoconf g++ make && \
  pecl install redis && \
  docker-php-ext-enable redis && \
  docker-php-ext-install bcmath && \
  docker-php-ext-install opcache && \
  docker-php-ext-install pdo && \
  docker-php-ext-install pdo_mysql && \
  docker-php-source delete

RUN rm -rf /var/cache/apk/*

###
# Install composer and prestissimo plugin
# (https://medium.com/@c.harrison/speedy-composer-installs-in-docker-builds-41eea6d0172b)
###
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer global require hirak/prestissimo --no-ansi --no-plugins --no-scripts
