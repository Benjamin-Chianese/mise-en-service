FROM php:7-apache

RUN apt-get update && apt-get install gettext-base && apt-get install -y git libgmp-dev && apt-get clean 

RUN docker-php-ext-install pdo pdo_mysql gmp

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#USER www-data
WORKDIR /var/www/html
COPY --chown=33:33 ./composer.json composer.json
RUN composer install

COPY --chown=33:33 ./includes /var/www/html/includes
COPY --chown=33:33 ./pages /var/www/html/pages
COPY --chown=33:33 ./index.php /var/www/html
COPY ./entrypoint.sh /usr/local/bin/personalized-entrypoint

ENTRYPOINT ["personalized-entrypoint"]

CMD ["apache2-foreground"] 
