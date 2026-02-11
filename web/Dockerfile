FROM php:8.2-apache

# Actualizar repositorios e instalar dependencias de sistema primero
RUN apt-get update && apt-get install -y --no-install-recommends \
    default-mysql-client \
    libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones necesarias para el frontend PHP
RUN docker-php-ext-install mysqli curl

# Copiar el código del frontend al contenedor
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html