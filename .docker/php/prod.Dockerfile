#composer dependencies.
# FROM composer As composer-build
# WORKDIR /app
# COPY composer.json composer.lock /app

# RUN mkdir -p /app/database/{factories,migrations, seeds} \
#     && composer install --no-dev --prefer-dist --no-scripts --no-autoloader --no-progress --ignore-platform-reqs


COPY public /app
#Actual production image
FROM php:8.1.3-fpm
RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    


WORKDIR /app
COPY . .
COPY --from=composer-build /app/vendor /app/vendor

RUN composer install
RUN composer dump -o \
    && composer check-platform-reqs \
    && rm -f /usr/local/bin/composer

EXPOSE 8000

# RUN groupadd --gid 1000 appuser \
#     && useradd --uid 1000 -g appuser \
#     -G www-data, root --shell /bin/bash \
#     --create-home appuser
# USER appuser