# Routing
1. Делаем перенаправление на index.php
```
//nginx
location / {
   try_files $uri $uri/ /index.php;
}
//apache
RewriteEngine on

RewriteBase /
RewriteCond %{HTTP_HOST} (.*)
RewriteCond %{REQUEST_URI} /$ [NC]
RewriteRule ^(.*)(/)$ $1 [L,R=301]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L]
```
2. Устанавливаем пакет `composer require phroute/phroute`
3. В index.php
```php
function processInput($uri): string
{
    $uri = urldecode(parse_url($uri, PHP_URL_PATH));
    return $uri;
}
$collector->get('/', function(){
    return "index page";
});

$collector->get('/ini', function(){
    return 'ini page';
});
$dispatcher =  new Dispatcher($collector->getData());

try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], processInput($_SERVER['REQUEST_URI']));
}catch(Phroute\Phroute\Exception\HttpRouteNotFoundException $e){
    echo $e->getMessage();
    die();
}catch(Phroute\Phroute\Exception\HttpMethodNotAllowedException $e){
    echo $e->getMessage();
    die();
}
echo $response;
```
