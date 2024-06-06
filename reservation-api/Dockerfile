FROM php:8.2-apache AS reservation-api
# Install dockerize so we can wait for containers to be ready
ENV DOCKERIZE_VERSION 0.7.0

ENV APP_HOME /var/www/html

RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
    && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.6.5

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libzip-dev \
        unzip \
        zip \
        nodejs \
        python3 \
    && apt-get clean \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
    && rm -rf /var/lib/apt/lists/*;

COPY . $APP_HOME

RUN composer install --no-interaction

COPY docker/php/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 80

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

CMD ["apache2-foreground"]
