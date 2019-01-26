FROM php:7.1.8-apache

MAINTAINER Paul Redmond

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update \
    && apt-get install -y unzip git \
    && docker-php-ext-install mbstring pdo pdo_mysql

RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
    && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
    # Make sure we're installing what we think we're installing!
    && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
    && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot \
    && rm -f /tmp/composer-setup.*

RUN a2enmod rewrite \
    && chmod 555 /srv/app/KSL/config.php

RUN useradd -ms /bin/bash kslUser
RUN rm /srv/app/KSL/vendor/* -rf
RUN chown -R kslUser:www-data /srv/app
#RUN chmod +x /srv/app/.docker/startup.sh
USER kslUser
WORKDIR /srv/app/KSL
RUN mkdir -p vendor
RUN composer install --verbose --no-dev #--dev

USER root



#RUN cd /srv/app/KSL && mkdir vendor && composer install --verbose --no-dev #--dev
#COPY /srv/app/KSL/vendor/autoload.php ./vendor/autoload.php
#RUN ls -l /srv/app/KSL/vendor
#RUN cat /srv/app/KSL/vendor/autoload.php
#RUN mkdir ./KSL/vendor
#COPY /srv/app/KSL/vendor/* ./KSL/vendor -R
