FROM webdevops/php-nginx:8.1
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    sudo apt update && sudo apt upgrade -y && sudo apt install make -y && \