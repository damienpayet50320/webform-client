FROM php:8.1-apache

# Copy application source
COPY src /var/www/
RUN chown -R www-data:www-data /var/www

RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80
