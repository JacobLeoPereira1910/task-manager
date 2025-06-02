FROM php:7.4-apache

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y unzip curl git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/

COPY composer.json composer.lock ./

RUN composer install --no-interaction --optimize-autoloader --no-dev

COPY . .

RUN chown -R www-data:www-data /var/www/html
RUN a2enmod rewrite

EXPOSE 80
