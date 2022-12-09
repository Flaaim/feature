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
## Rendering Template
1. Устанавливаем Twig. Документация по twig: https://github.com/slimphp/Twig-View
```
    composer require slim/twig-view
```
2. Создаем папку views. Создаем файл home.twig
```php
    use Slim\Views\Twig;
    use Slim\Views\TwigMiddleware;

    $container->set('hello', function(){
        return Twig::create('views', ['cache' => false]);
    });

    $app->add(TwigMiddleware::createFromContainer($app, 'hello'));

    $app->get('/', function(Request $request, Response $response){
        return $this->get('hello')->render($response, 'home.twig');
    });
```
### Передача данных в шаблон.
```php
    $app->get('/', function(Request $request, Response $response){
        $users = ['Alex', 'Anna', 'Kostya'];
        return $this->get('hello')->render($response, 'home.twig', compact($users));
    });
```
## Отправка данных методом POST
1. Создаем view с формой.
```
{% extends "layouts/app.twig" %}

{% block content %}
        <form action="{{ url_for('contact') }}" method="POST">
            <input type="text" name="name" id="name">
            <button type="submit">Send</button>
        </form>
{% endblock %}
```
2. Создаем route c методом post
```php
    $app->post('/contact', function(Request $request, Response $response){
        $data = $request->getParsedBody();
        var_dump($data);
        die();
    })->setName('contact');
```
## Передача параметров в Route
1. Создадим Route
```php
$app->get('/profile/{username}', function(Request $request, Response $response, $args){
    var_dump($args);
    die();
})->setName('profile');
```
### Route group
```
$app->group('/profile/{username}', function($group){
    $group->get('', function(Request $request, Response $response, $args){
        $user = $args['username'];
        return $this->get('hello')->render($response, 'profile.twig', ['username' => $user]);
    })->setName('profile');

    $group->get('/post/{id}', function(Request $request, Response $response, $args){
        $id = $args['id'];
        return $this->get('hello')->render($response, 'post.twig', ['id' => $id]);
    });
});
```
### Redirect route
1. Простой редирект
```php
$app->get('/one', function(Request $request, Response $response){
    return $response->withHeader('Location', '/two')->withStatus(302);
});

$app->get('/two', function(Request $request, Response $response){
    $response->getBody()->write('two');

    return $response;
});

```
2. Редирект с named routes
```php
    $app->get('/one', function(Request $request, Response $response) use($app) {
        return $response->withHeader('Location', $app->getRouteCollector()->getRouteParser()->urlFor('two'))->withStatus(302);
    })
        ->setName('one');

    $app->get('/post/two', function(Request $request, Response $response){
        $response->getBody()->write('two');
        return $response;
    })
        ->setName('two');
```
## JSON response
```php
$app->get('/json', function(Request $request, Response $response){
    $data = [
        'name' => 'Harry', 'surname' => 'Potter'
    ];
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});
```
## Slim project Template
see https://github.com/Flaaim/slim_template
```
    - vendor
    - public
        - index.php
        - .htaccess
    - routes
        - web.php
    - bootstrap
        - app.php
        - middleware.php
        - container.php
```
