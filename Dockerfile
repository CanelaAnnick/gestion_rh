FROM php:8.3-apache

# Installation des dépendances système + Node.js
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libzip-dev libpq-dev unzip curl git \
    nodejs npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation des extensions PHP
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip opcache

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ON COPIE TOUT LE CODE D'ABORD (Pour éviter l'erreur artisan manquant)
COPY . .

# Installation des dépendances PHP
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# Installation des dépendances NPM et Compilation du CSS
RUN npm install
RUN npm run build

# Configuration d'Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/docker-php.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/security.conf

RUN a2enmod rewrite

# Permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]