FROM php:8.3-apache

# Install ekstensi & dependency PHP
RUN apt-get update && apt-get install -y \
    git unzip curl gnupg libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring zip exif bcmath

# Aktifkan mod_rewrite untuk Laravel route
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js LTS + npm
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Set workdir
WORKDIR /var/www/html

# Copy project
COPY . .

# Install Laravel dependencies dan build assets
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install && npm run build || true

# Generate APP_KEY (tidak error jika sudah ada)
RUN php artisan key:generate || true

# Permission storage dan cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Atur DocumentRoot Apache
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
