FROM nginx:latest
RUN apt-get update && apt-get install -y nano


RUN mkdir -p /var/www/html

COPY nginx_template_local.conf /etc/nginx/conf.d/default.conf
RUN cd ../ && COPY . /var/www/html

EXPOSE 80
CMD ["nginx-debug", "-g", "daemon off;"]