FROM php:7.3-apache

COPY ./src /var/www/html

RUN apt-get update && \
    apt-get install -y \
    	unzip && \
    docker-php-ext-install pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/html/ && \
	composer require league/plates