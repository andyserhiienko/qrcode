FROM php:8.2-apache

# Installing PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpng-dev libjpeg-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy Apache config
COPY ./apache/default.conf /etc/apache2/sites-available/genomed.tt.conf

# Enable Our Project
RUN a2ensite genomed.tt.conf && a2dissite 000-default.conf

# Copy Our Project
COPY . /var/www/genomed.tt/

# Set Work-directory
WORKDIR /var/www/genomed.tt
