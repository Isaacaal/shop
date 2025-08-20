FROM php:8.3-apache

# Install deps
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libsqlite3-dev \
    && docker-php-ext-install intl pdo pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Apache config : DocumentRoot = /var/www/public
RUN sed -i 's|/var/www/html|/var/www/public|g' /etc/apache2/sites-available/000-default.conf

# Fix permissions
RUN chown -R www-data:www-data /var/www
