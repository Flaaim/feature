# Контейнерезация laravel приложения.
  1. Создаем папку проекта app. Внутри папки создаем файл docker-compose.yml
  ```yml
  version "3.8"
  
  services:
    nginx:
      container_name: nginx
      build: ./docker/nginx
      command: nginx -g "daemon off;"
    ports:
      - "80:80"
    volumes:
      - ./logs/nginx/:/var/log/nginx
      - ./src/app:/var/www/html/app
    php:
      container_name: php
      build: ./docker/php
    ports: 
      - "9000:9000"
    volumes: 
      - ./src/app:/var/www/html/app
    working_dir: /var/www/html/app
  composer:
    container_name: composer
    image: composer/composer
    volumes:
      - ./src/app:/var/www/html/app
    working_dir: /var/www/html/app
    command: install  //или update если приложение уже разработано, если ошибки не устраняются то флаг --ignore-platform-reqs
  ```
  2. В директории app создаем необходимые директории docker/nginx, docker/php, logs/nginx, src
  3. Создаем Dockerfile в директории docker/php
  ```
FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y openssl zip unzip git curl
RUN apt-get install -y libzip-dev libonig-dev libicu-dev
RUN apt-get install -y autoconf pkg-config libssl-dev


RUN docker-php-ext-install bcmath mbstring intl opcache
  ```
4. В директории docker/nginx создаем 2 файла Dockerfile, app.nginx.conf
```
  //app.nginx.conf
  
  server {
    listen 80;
    index index.html index.php;

    root /var/www/html/medcheckup-app/public;
    
    error_log /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
		try_files $uri =404;
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		fastcgi_pass php:9000;
		fastcgi_index index.php;
		include fastcgi_params;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		fastcgi_param PATH_INFO $fastcgi_path_info;
	}
}
```

```
//Dockerfile
FROM nginx

ADD medcheckup.nginx.conf /etc/nginx/conf.d/default.conf
```
5. В директорию src копируем или создаем laravel проект. src/app/... файлы проекта
6. Выполняем docker-compose build, docker-compose up. http://localhost/ должне появиться проект.
 




