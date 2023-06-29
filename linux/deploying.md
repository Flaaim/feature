# Развертывание.

1. Создаем tag. 
```
git tag -a 'v1.0.0' -m'realease 1.0.0'
git push origin --tags
```
3. Скачиваем архив с tag github.
4. Загружаем архив на хостинг
```
scp <file> username@remotehost:/path/to/destination
```
5. Разархивируем архив. 
6. Устанавливаем composer
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
8. Обновляем php версию (при необходимости)
```
//задаем переменную
PATH=/opt/php/8.1/bin/php-cgi

//выполняем composer update с PATH
$PHP composer.phar update
```
В директории проекта создаем .htaccess. редирект с папки проекта на папку public, где храниться index.php
```
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```
9. Проверяем права созданных файлов. Смотрим логи ошибок вебсервера. 
```
chmod -R 755 name_of_project
chmod -R o+w name_of_project/storage
```
10. На локальной машине запускаем npm run build.
11. Копируем папку build в public/build 
12. Удаляем с app.blade.php, оставляем только @vite('resources/js/app.js')
```
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/css/app.css'])
```
### Редирект с root на public/index.php
```
RewriteEngine On
RewriteCond %{REQUEST_URI} !^public
RewriteRule ^(.*)$ public/$1 [L]
```
