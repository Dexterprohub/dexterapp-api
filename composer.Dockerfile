#Get Composer
FROM composer

WORKDIR /app

COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

COPY . .
RUN composer dump-autoload

COPY --from=vendor app/vendor/ ./vendor/
COPY . .

RUN php artisan optimize:clear

CMD php artisan serve --host=0.0.0.0 --port=8080

EXPOSE 80