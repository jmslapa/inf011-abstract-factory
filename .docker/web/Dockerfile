FROM wyveo/nginx-php-fpm:php74

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /usr/share/nginx

RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && apt-get update -y \
    && apt-get install openjdk-11-jdk -y \
    && apt-get install g++ -y

RUN chmod -R 777 . \
    && umask 000