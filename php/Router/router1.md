# Router attempt #1

## Что нам понадобится
1. Класс Router. 
2. Файл с маршрутами. 
3. Строка запроса, которую будем обрабатывать.

## Готовим роутер. 
### Подготовка.
1. `$url = trim(urldecode($_SERVER['REQUEST_URI']), '/')` - ловим запрашиваемую строку в переменную $url, обрезаем слеш в конце. 
2. Передаем `$url` в метод класса `Router::dispatch($url);`

### Файл с маршрутами
```php
<?php

use Wfm\Router;

Router::add("^$", ['controller' => 'Main', 'action' => 'index']);
Router::add("^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$");
```
### Класс Router
1. Класс состоит из `статических` методов и переменных. 
```php
class Router
{
  protected static $routes = [] //хранит маршруты из файла с маршрутами
  protected static $route = [] //хранит текущий маршрут.
  
  public static function add($regex, $route = [])  
  {
    self::$routes[$regex] = $route //Добавляем маршрут в переменную $routes. [Ключ] хранит паттерн, [значение] маршрут по умолчанию.
  }
  
  public static function dispatch($url)
  {
    if(self::matchRoute($url)){
        //определяем дальше контроллер
    }
  }
  public static function matchRoute($url): bool
  {
      //Обходим массив с маршрутами
      foreach(self::$routes as $pattern => $route){
        //проверяем соответсвие функцией preg_match совпадение url и паттерна
        if(preg_match("#{$pattern}#", $url, $matches)){
          //обходим $matches
          foreach($matches as $key => $value){
            //если matches содержит строку 'controller' или 'action'
            if(is_string($key)){
              //добавляем их в $routes
              $route[$key] = $value; //['controller' => 'product', 'action' => 'index']
            }
            //если в url не задан метод /product, добавляем метод по умолчанию.
            if(empty($route['action'])){
              $route['action'] = 'index';
            }
          }
          $route['controller'] = self::upperCase($route['controller']); //вспомогательный метод
          $route['action'] = self::lowerCase($route['action']); //вспомогательный метод
          self::$route = $route;
          return true;
        }
      }
    return false;
  }
  
  //Вспомогательные методы
      protected static function upperCase($str): string
    {
        return str_replace('-', '', ucwords($str, '-'));
    }
    protected static function lowerCase($str):string
    {
        return lcfirst(self::upperCase($str));
    }
    protected static function removeQueryString($url)
    {
        $url = self::changeUrl($url);
        
            if(!empty($url)){
            $params = explode('&', $url, 2);
                if(str_contains($params[0], '=') === false){
                    return trim($params[0], '/');
                }
            }
        return '';
    }
    protected static function changeUrl($url)
    {
        return str_replace('?','&', $url);
    }
}
```
