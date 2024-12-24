Используем Docker nginx:1.27-alpine.

В корне проекта создаем папку /docker.

```
docker
|_ nginx
  |_conf.d
    |_ default.conf
  - Dockerfile
```

Файл default.conf
```
server {
  listen 80;
  server_name localhost;
  charset utf-8;
  index index.html;

  root /app/public;
}

```
Файл Dockerfile
```
FROM nginx:1.27-alpine

COPY ./conf.d /etc/nginx/conf.d

WORKDIR /app

```
В корне сайта создаем файл docker-compose.yml
```
version: "3.9"
services:
    nginx:
        build:
            context: docker/nginx
        ports:
            - "80:80"
        volumes:
            - ./:/app

```
Запускаем командами:
```
docker-compose build --pull
docker-compose up -d

```
