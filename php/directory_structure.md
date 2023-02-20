# Структура php проекта.

1. Создаем директорию проекта. `frame`

2. Проект будет содержать следующие папки:
```
  - app   /Файлы проекта
  - public 
  - routes
  - views
  - vendor
  - tests
```
3. Создаем в папке `public` файл `index.php`
4. Перенаправляем все запросы на index.php 
4.1 На apache:
```php

```
4.2 На nginx 
```php

```
5. Подключаем автозагрузку классов.
В директории проекта создаем composer.json. Запускаем `composer update`. 
```json
      "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
```
6. В файле index.php подключает файл autoload.php
```php
  require_once("../vendor/autoload.php");
```
