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
          foreach($matches as $key => $value){
            if(is_string($key)){
              $route[$key] = $value;
            }
            
            if(empty($route['action'])){
              $route['action'] = 'index';
            }
          }
          $route['controller'] = self::upperCase($route['controller']);
          $route['action'] = self::lowerCase($route['action']);
          self::$route = $route;
          return true;
        }
      }
  return false;
  }
}
```
