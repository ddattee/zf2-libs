#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update && apt-get upgrade -yqq
apt-get install apt-utils git zlib1g-dev -yqq
pecl install xdebug

cd $CI_PROJECT_DIR
mkdir bin

# Install composer, the tool that we will use for testing
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=bin --filename=composer
php -r "unlink('composer-setup.php');"

# Here you can install any other extension that you need
docker-php-ext-configure zip --with-libdir=lib/x86_64-linux-gnu/ && \
docker-php-ext-install zip
docker-php-ext-enable xdebug