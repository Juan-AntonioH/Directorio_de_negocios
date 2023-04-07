FROM php:8.1-apache
ENV TZ=Europe/Madrid
RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
        openssl \
        git \
        nano \
        wget \
        cron \
        tzdata \
        mariadb-client \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli zip soap bcmath \
    && docker-php-source delete

#RUN pecl install xdebug-3.1.0 \
#    && docker-php-ext-enable xdebug

COPY xdebug.ini "$PHP_INI_DIR/conf.d/20-xdebug.ini"
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

#Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite
#Instalar cron (comentado por que al levantar docker en windows no funciona)
#COPY idasfest-cron "/etc/cron.d/idasfest-cron"
#RUN chmod 0644 /etc/cron.d/idasfest-cron
#RUN crontab /etc/cron.d/idasfest-cron
#RUN touch /var/log/cron.log

CMD cron && /usr/sbin/apache2ctl -D FOREGROUND
