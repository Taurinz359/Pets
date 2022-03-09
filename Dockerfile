FROM webdevops/php-nginx:8.1
RUN pecl install xdebug && docker-php-ext-enable xdebug
