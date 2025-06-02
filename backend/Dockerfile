FROM php:7.4-apache


RUN docker-php-ext-install pdo pdo_mysql


RUN apt-get update && apt-get install -y unzip curl \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer


COPY . /var/www/html/


WORKDIR /var/www/html
RUN composer install


RUN chown -R www-data:www-data /var/www/html


RUN a2enmod rewrite


COPY .htaccess /var/www/html/.htaccess
