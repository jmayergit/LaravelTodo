FROM php:7.3.21-cli
RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
CMD ["php", "artisan", "migrate"]
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000