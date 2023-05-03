FROM php:8.1-fpm-alpine
RUN apk add --no-cache mysql-client msmtp perl wget procps shadow libzip libpng libjpeg-turbo libwebp freetype icu

RUN apk add --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip && \ 
    apk del build-essentials && rm -rf /usr/src/php*
# RUN docker-php-ext-enable pdo pdo_mysqli \

# Install Node.js and npm
RUN apk add --no-cache nodejs npm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php


WORKDIR /var/www/html

COPY . .
# RUN docker-php-ext-install gd
# COPY ./config/php/local.ini /usr/local/etc/php/conf.d/local.ini

# RUN addgroup -g 1000 -S www-data && \
#     adduser -u 1000 -S www-data -G www-data
# USER www-data
# COPY --chown=www-data:www-data . /var/www/html

# RUN	chmod 775 /var/www/html \



EXPOSE 9000
CMD ["php-fpm"]

# RUN chown -R www-data:www-data /var/www/html
# USER www-data
