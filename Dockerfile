FROM php:7.4-apache

WORKDIR /var/www/html

COPY . .

RUN apt-get update && \
    apt-get install -y libpng-dev && \     
    docker-php-ext-install pdo pdo_mysql gd && \
    docker-php-ext-install mysqli

EXPOSE 80

CMD ["apache2-foreground"]
