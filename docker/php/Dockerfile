FROM php:8.3-fpm

# Install the PHP MySQL extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install required system dependencies
RUN apt-get update && \
    apt-get install -y unzip git

#RUN #sh -c "chmod -R 777 /var/www/tcpa/storage /var/www/tcpa/bootstrap/cache && php-fpm"
# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www/tcpa

EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
