FROM php:8.2-fpm

RUN apt-get update -y && apt-get install -y libpng-dev libssl-dev libjpeg-dev libfreetype6-dev libzip-dev unzip git 
RUN apt-get install -y default-mysql-client
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html

COPY . .

RUN composer install 

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
