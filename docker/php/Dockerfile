FROM php:fpm-alpine
RUN apk --update --no-cache add git
RUN apk add --update --no-cache libintl icu icu-dev \
&& docker-php-ext-install pdo_mysql intl
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install ; bin/console doctrine:migrations:migrate ;  php-fpm 
EXPOSE 9000