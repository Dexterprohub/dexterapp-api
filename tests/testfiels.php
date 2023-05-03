version: '3.7'
services:

backend:
container_name: micro_api
build:
context: .
dockerfile: Dockerfile
environment:
DB_HOST: db

DB_DATABASE: admin
DB_USERNAME: root
DB_PASSWORD: root
ports:
- 80:80
volumes:
- .:/app
depends_on:
- db
networks:
- app


db:
container_name: micro_db
image: mysql:8

cap_add:
- SYS_NICE # CAP_SYS_NICE
environment:
MYSQL_DATABASE: admin
MYSQL_PASSWORD: root
MYSQL_ROOT_PASSWORD: root
volumes:
- .dbdata:/var/lib/mysql
ports:
- 3306:3306

networks:
- app
networks:
app:


FROM php:8.1.3



RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



WORKDIR /app
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0
EXPOSE 8000