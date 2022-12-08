# Slim установка и настройка.
## Первоначальная установка
1. Создаем проект mkdir slim && cd slim
2. Composer `require slim/slim "4.*"`
3. Composer `require slim/psr7`
4. Создаем index.php
```php

require 'vendor/autoload.php';

    use Slim\Factory\AppFactory;

    $app->AppFactory::create();

    $app->run();

```
## Добавляем ErrorMiddleware
1. Для отображения ошибок.
```php
    use Slim\Middleware\ErrorMiddleware;


    $errorMiddleware = new ErrorMiddleware(
        $app->getCallableResolver(),
        $app->getResponseFactory(),
        true,
        false,
        true,
    );

    $app->add($errorMiddleware);

```
## Создаем Route
1. Подключаем PSR7
```php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;  
```
2. Добавляем route
```php

$app->get('/', function(Request $request, Response $response){
    $response->getBody()->write('Hello');
    return $response;
});

```
## Apache rewrite
1. Создаем .htaccess
```
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
```
## Container
1. composer require php-di/php-di
```php
    use DI\Container;

    $container = new Container();
    AppFactory::setContainer($container);

    //$app = AppFactory::create();   
     
    $app->set('hello', function(){
        return 'Hello!';
    });

```


