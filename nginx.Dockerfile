FROM nginx:1.23.3
RUN apt-get update && apt-get install -y nano
RUN apt-get install -y sudo

RUN mkdir -p /var/www/html

COPY nginx_template_local.conf /etc/nginx/conf.d/default.conf
COPY . /var/www/html
# RUN chown www-data:www-data /var/www/html
# USER www-data
# RUN chmod 775 /var/www/html

EXPOSE 80
