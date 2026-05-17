FROM php:7.4-apache

# Instalar extensión MySQLi
RUN docker-php-ext-install mysqli

# Copiar archivos del proyecto
COPY . /var/www/html/

# Dar permisos
RUN chown -R www-data:www-data /var/www/html/

# Exponer puerto
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
