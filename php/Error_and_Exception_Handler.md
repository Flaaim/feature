# Класс обработки ошибок и исключений

0. Необходимо определить константу, например `DEBUG`, которая будет менять отображение ошибок error_reporting();

2. Создаем класс `ErrorHandler`. Подключаем класс к проекту.
3. Определяем в классе конструктор. 
4.1. Конструктор проверяет константу `DEBUG`, и выводит либо не выводит сообщения об ошибках.
5.2 Определяем `set_exception_handler();`
```php
  public function __construct()
  {
      if(DEBUG){
        error_reporting(-1);
      }else {
        error_reporting(1);
      }
      set_exception_handler([$this, 'exceptionHandler']); //Отлавливает исключения
  }

``` 
4. Определяем в классе `ErrorHandler` метод `exceptionHandler()`.
```php
  public function exceptionHandler(\Throwable $e)
  {
    $this->logError($e->getMessage(), $e->getFile(), $e->getLine());
    $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
  }
  protected function logError($message = '', $file = '', $line = '')
  {
    file_put_contents(LOGS . '/errors.log', "[" . date("d.m.Y h:i:s ") . "Сообщение: " . $message . " Файл: " . $file . " Строка: " . $lin . " ]\r\n", FILE_APPEND);
  }
  protected function displayError($errno, $errstr, $errfile, $errlin, $response = 500)
  {
      if($response == 0){
        $response = 404;
      }
      http_response_code($response);
      if($response == 404 && !DEBUG){
        require_once('/public/errors/404.php');
      }
      if(DEBUG){
        require_once('/public/errors/development.php');
      } else {
        require_once('/public/errors/production.php');
      }
      
  }

```
