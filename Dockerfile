FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libsqlite3-dev \
 && docker-php-ext-install intl pdo pdo_sqlite zip \
 && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf \
 && printf "\n<Directory /var/www/public>\n  AllowOverride All\n  Require all granted\n</Directory>\n" >> /etc/apache2/apache2.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
