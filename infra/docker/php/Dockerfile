FROM php:8.0.12-fpm-bullseye

# timezone environment
ENV TZ='Asia/Tokyo' \
  # locale
  LANG=ja_JP.UTF-8 \
  LANGUAGE=ja_JP:ja \
  LC_ALL=ja_JP.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install git libicu-dev libonig-dev libzip-dev libjpeg-dev libpng-dev zlib1g-dev unzip locales libldap2-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  locale-gen ja_JP.UTF-8 && \
  localedef -f UTF-8 -i ja_JP ja_JP.UTF-8 && \
  mkdir /var/run/php-fpm && \
  docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu && \
  docker-php-ext-install intl pdo_mysql zip bcmath ldap && \
  composer config -g process-timeout 3600 && \
  composer config -g repos.packagist composer https://packagist.org

RUN docker-php-ext-configure gd --with-jpeg && \
  docker-php-ext-install intl pdo_mysql zip bcmath gd

COPY ./infra/docker/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./infra/docker/php/php.ini /usr/local/etc/php/php.ini

WORKDIR /work/backend
