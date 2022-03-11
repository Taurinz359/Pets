# Slim PHP Package

Slim 4 Framework package example

## Requirements

* PHP 8.1 
* PostgreSQL 13
* Nginx 

## Install and start app (with docker-compose)

```shell
docker-compose build
docker-compose up -d
docker-compose exec app make install 
docker-compose exec app make migrate

```
