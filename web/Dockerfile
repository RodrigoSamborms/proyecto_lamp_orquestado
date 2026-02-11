FROM php:8.2-apache

# Actualizar repositorios e instalar dependencias de sistema primero
RUN apk update && apk add --no-cache \
    $PHPIZE_DEPS \
    mysql-client

# Instalar extensiones necesarias para el frontend PHP
RUN docker-php-ext-install mysqli

# Copiar el código del frontend al contenedor
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html