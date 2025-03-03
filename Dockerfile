FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install redis && \
    docker-php-ext-enable redis

RUN a2enmod rewrite

WORKDIR /var/www/tracking-views

COPY . .

RUN chown -R www-data:www-data /var/www/tracking-views

RUN find /var/www/tracking-views -type d -exec chmod 755 {} \; \
    && find /var/www/tracking-views -type f -exec chmod 644 {} \;

RUN sed -i 's|/var/www/html|/var/www/tracking-views/public|' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|<Directory /var/www/html>|<Directory /var/www/tracking-views/public>|' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|AllowOverride None|AllowOverride All|' /etc/apache2/apache2.conf

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN composer install

EXPOSE 80

CMD ["apache2-foreground"]
