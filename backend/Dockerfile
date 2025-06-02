FROM php:7.4-apache

# Instala extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instala dependências para composer (unzip, curl, git)
RUN apt-get update && apt-get install -y unzip curl git

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia os arquivos da aplicação para o container
COPY . /var/www/html/

# Define o diretório de trabalho
WORKDIR /var/www/html/

# Permissões para o Apache
RUN chown -R www-data:www-data /var/www/html

# Ativa mod_rewrite
RUN a2enmod rewrite

# Roda composer install dentro do container para garantir compatibilidade
RUN composer install --no-interaction --optimize-autoloader --no-dev

EXPOSE 80
