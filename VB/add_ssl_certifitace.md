# Добавление SSL сертификата для nginx

1. Переходим в виртуальную машину Ubuntu. Обновляем sudo apt-get update. 
2. Вводим команду
```
  sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt
```
3. Заполняем информацию
```
Country Name (2 letter code) [AU]:US
State or Province Name (full name) [Some-State]:New York
Locality Name (eg, city) []:New York City
Organization Name (eg, company) [Internet Widgits Pty Ltd]:Bouncy Castles, Inc.
Organizational Unit Name (eg, section) []:Ministry of Water Slides
Common Name (e.g. server FQDN or YOUR name) []:server_IP_address
Email Address []:admin@your_domain.com
```
4. В директории /etc/ssl в папках certs и private будут находиться ключи. Данные ключи необходимо копировать в свою директорию проекта, например папку с конфигами nginx
```
docker
  - nginx
    - ssl
      - nginx-selfsigned.crt
      - nginx-selfsigned.key
    -default.conf
    ...
 ```
5. В docker-compose.yml service nginx пробрасываем ключи в контейнер
 ```
 volumes:
  - ./docker/nginx/ssl:/etc/nginx/ssl
```
6. В docker-compose.yml service nginx изменяем ports
```
ports:
  - "8080:443"
```
8. Обновляем nginx default.conf
```
listen 443 ssl; // меняем с 80
//Добавляем
ssl on;
ssl_certificate /etc/nginx/ssl/nginx-selfsigned.crt;
ssl_certificate_key /etc/nginx/ssl/nginx-selfsigned.key;
```
