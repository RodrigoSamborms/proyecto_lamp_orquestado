FROM php:8.2-apache

# Actualizar repositorios e instalar dependencias de sistema primero
RUN apt-get update && apt-get install -y --no-install-recommends \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli

# Copiar el código de la API al contenedor
COPY . /var/www/html/

# Establecer permisos (opcional pero recomendado)
RUN chown -R www-data:www-data /var/www/html