# Контейнерезация laravel приложения.
1. Устанавливаем/копируем проект. Composer create-project laravel/laravel myproject
2. В папке проекта создаем файл docker-compose.yml
3. В папке myproject создаем директорию docker.
```yml
version: "3.8"

services:
	nginx:
		image: nginx
		ports:
			- "8080:80"
		volumes:
			- ./docker/nginx/config/:/etc/nginx/conf.d
			- ./docker/nginx/log/:/var/log/nginx
			- ./:/var/www
		depends_on:
			- php
```
3. Структура папок будет следующая
```yml
myproject
    - docker
		- nginx
			- config
				default.conf
			- log
				//logs
		- php
			php-fpm.dockerfile
```
4. Создаем конфиг для nginx
```
server {
	listen 80;
	index index.php index.html;
	root /var/www/public;
    
    #ssl on;
    #ssl_certificate /etc/nginx/ssl/nginx-selfsigned.crt;
    #ssl_certificate_key /etc/nginx/ssl/nginx-selfsigned.key;

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
5. Добавляем php в docker-compose.yml
```yml
php:
	build:
		context: ./
		dockerfile: ./docker/php/php-fmp.dockerfile
	volumes:
		- ./:/var/www
```
6. Добавляем mysql
```yml
mysql:
	image: mysql
	ports:
		- "33061:3306"
	volumes:
		- ./storage/docker/mysql:/var/lib/mysql
	enviroment:
		  - "MYSQL_ROOT_PASSWORD=secret"
      - "MYSQL_USER=app"
      - "MYSQL_PASSWORD=secret"
      - "MYSQL_DATABASE=roles-permissions"
//Добавляем что php
    depends_on:
      - mysql
```
### Настройка MYSQL
В файле .env в настройках базы данных прописываем:
```
DB_HOST=mysql //название service из docker-compose.yml
DB_PORT=3306 //порт
DB_DATABASE=app // из environment docker-compose.yml
DB_USERNAME=app // из environment docker-compose.yml
DB_PASSWORD=secret // из environment docker-compose.yml
```
### Добавляем MailHog
в файл docker-compose.yml добавляем:
```
mailhog:
	image: mailhog/mailhog
	logging:
  	driver: 'none' # disable saving logs
	port:
		- 1025:1025
		- 8025:8025
	
```
В .env файле прописываем:
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="Admin@email.com"
MAIL_FROM_NAME="${APP_NAME}"
```
### Устранение ошибок 
1. The stream or file "/var/www/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied 
```
//выполнить
chown -R www-data:www-data /var/www
```
=====================================================	















## Страрая версия
  1. Создаем папку проекта Project. Внутри папки создаем файл docker-compose.yml
  ```yml
  version "3.8"
  
  services:
    nginx:
      image: nginx
    ports:
      - "8080:80"
    volumes:
      - ./nginx/config/:/etc/nginx/conf.d
      - ./nginx/log/:/var/log/nginx
      - ./code:/code
    depends_on:
      - php
    networks:
      - network-project
    php:
      build: ./php
    ports: 
      - "9000:9000"
    volumes: 
      - ./code:/code
    networks:
      - network-project
networks:
  network-project:
    driver: bridge
    
  ```
  2. В директории project создаем необходимые директории /nginx, /php, /code
  3. Создаем Dockerfile в директории /php
  ```
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sL https://deb.nodesource.com/setup_19.x | bash - 
RUN apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /code
  ```
4. В директории nginx/config создаем файл default.conf
```
  #default.conf
  
  server {
	listen 80;
	index index.php index.htm index.html;
    server_name localhost;
	root /code/public;

	error_log  /var/log/nginx/error.log;
	access_log /var/log/nginx/access.log;

	location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
        location / {
        try_files $uri $uri/ /index.php?$query_string;
        gzip_static on;
    }
}
```
5. В директорию code копируем или создаем laravel проект. src/app/... файлы проекта
6. Выполняем docker-compose up --build, docker-compose up. http://localhost/ должне появиться проект.
7. При копировании проекта внутри контейнера /code запускаем composer update. Устанавливаем все зависимости. Создаем файл .env, выполняем команду php artisan key: generate.
8. Через visual studio code (не в контейнере!!) выполняем команды npm install && npm run dev.
 

## Добавление phpmyadmin
1. В файл docker-compose.yml добавляем:
```yml
phpmyadmin:
    image: phpmyadmin
    restart: always
    environment:
      - "PMA_HOST=mysql"
      - "PMA_PORT=3306"
    depends_on:
      - mysql
    ports:
      - "8888:80"
  ```
  ## Использование томов
 ```
 mysql:
    volumes: 
        - "mysql_data:/var/lib/mysql"
        
 volumes:
    mysql_data:
 
 


