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
```php
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
see 
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
## Add Controller
1. Создаем директорию app. В данной директории будут храниться контроллеры, модели и т.д.
2. Добавляем автозагрузку.
```json
    "autoload": {
        "psr-4": {
            "App\\": "app"
        }
    }
```
3. Выполняем composer dump-autoload -o
### Вынос методов в контроллер
```php
//web.php
use App\Controllers\HomeController;

$app->get('/', HomeController::class . ':index')  ->setName('home');

//app/Controllers/HomeController.php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController {
    public function index(Request $request, Response $response){
        $response->getBody()->write('Hello');

        return $response;
    }
}
```
## Рендеринг template и регистрация контроллера в контейнере
1. Добавляем в контроллер 
```php
//HomeController
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }
```
2. Добавляем в container.php
```php
$container->set(HomeController::class, function($container){
   $view = $container->get('view');
   return new HomeController($view);
});
```
## PDO
1. Добавляем новый контейнер
```php
//container.php
$container->set('db', function(){
    return new PDO('mysql:dbname=slim;host=localhost', 'root', '');
});

$container->set(HomeController::class, function($container){
    $view = $container->get('view');
    $db = $container->get('db');
    return new HomeController($view, $db);
});
```
2. Обновляем метод __construct() в HomeController
```php
    public function __construct(Twig $view, $db)
    {
        $this->view = $view;
        $query = $db->query('SELECT * FROM users');
        $query->execute();

        var_dump($query->fetchAll(PDO::FETCH_OBJ));
    }
```
## Custom 404 page
1. В middleware.php добавляем $errorMiddleware
```php
//middleware.php
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

$errorMiddleware->setErrorhandler(HttpNotFoundException::class, function($request, $exception) use ($container){
    $response = new Response();
    return $container->get('view')->render($response->withStatus(404), 'errors/404.twig');
});
```
2. В контроллере перехват ошибки 404
```php
if($query->rowCount() === 0){
    throw new HttpNotFoundException($request);
}
```
## Add Custom Middleware
```php
//middleware.php
$beforeMiddleware = function(Request $request, Requesthandler $handler){
    $response = $handler->handle($request);
    $signedIn = true;

    if(!$signedIn){
        var_dump('You are not signed');
        die();
    }
    return $response;
};
$app->add($beforeMiddleware);
```
Выносим middleware в отдельный файл. App/Middleware/AuthMiddleware.php
```php
class AuthMiddleware {

public function __invoke(Request $request, Requesthandler $handler){
    $response = $handler->handle($request);
    $signedIn = false;
    
    if(!$signedIn){
       var_dump("You are not sign in");
       die();
    }
    return $response;
    }
}
```
`$app->add(new AuthMiddleware());` оставляем также.
## Middleware to Route

