# Создание проекта
1. Создаем директории
```
app
public
  |___ index.php
app.php
```
2. Устанавливаем зависимости
```bash
composer require nikic/fast-route
composer require pimple/pimple ~3.0
composer require twig/twig ^3.0
```
3. В директории /app Создаем конфиг config.php
```php
//config.php
<?php
return [
    'database' => [
        'host' => '127.0.0.1',
        'user' => 'root',
        'pass' => '',
        'name' => 'app'
    ],
    'debug' => true
];
```
4. Настраиваем автозагрузку.
```json
//composer.json
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    }
```
выполняем команду: composer dump-autoload
Настраиваем app.php
```php
<?php

use Pimple\Container;

require 'vendor/autoload.php';

$container = new Container();
$container['config'] = require __DIR__.'/app/config.php';
$container['db'] = function($c){
    $db = $c['config']['database'];
    $url = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'] . ';charset=utf8mb4';
    return new PDO($url, $db['user'], $db['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
};

if ($container['config']['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

В config.php прописываем данные подключения к бд.
//проверяем работу

```
5. Настраиваем шаблонизатор
   



