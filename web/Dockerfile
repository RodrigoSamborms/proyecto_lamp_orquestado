FROM php:8.2-apache

# Instalar extensiones necesarias para el frontend PHP
RUN docker-php-ext-install mysqli

# Copiar el código del frontend al contenedor
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html