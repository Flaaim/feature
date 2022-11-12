# Контенеризация NGINX and PHP

Nginx расположение
```
config: /etc/nginx/conf.d/default.config
logs: /var/log/nginx/error.log  /var/log/nginx/access.log
public: /usr/share/nginx/html
```
1. Создаем директорию будущего проекта. project1 В project1 создаем файл docker-compose.yml
```yml
  version "3.7"
  
  services:
    web:
      image: nginx:latest
      ports:
        - "8080:80"
      volumes:
        - ./code:/usr/share/nginx/html
        - ./config:/etc/nginx/conf.d
        - ./logs:/var/log/nginx
      depends_on:
        php
    php:
      image: php:8.1-fpm-alpine
      volumes:
        - ./code:/usr/share/nginx/html


```
