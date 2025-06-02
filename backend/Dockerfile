FROM php:7.4-apache

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer
RUN apt-get update && apt-get install -y unzip curl \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Copia o projeto
COPY . /var/www/html/

# Define diretório
WORKDIR /var/www/html

# Roda o composer install baseado no lock
RUN composer install

# Permissões
RUN chown -R www-data:www-data /var/www/html

# Ativa mod_rewrite do Apache
RUN a2enmod rewrite

# Copia .htaccess (se não veio junto acima)
COPY .htaccess /var/www/html/.htaccess
