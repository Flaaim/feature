# Обработка ошибок
1. Файл App\Exceptions\Handler.php
2. Добавляем исключения, которые будем обрабатывать 
```php
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
```
3. Обновляем метод register();
```php
  $this->renderable(function(Exception $e, $request){
    return $this->handleException($e, $request);
  });
 ```
 4. Описываем метод handleException();
 ```php
  private function handleException($exception, $request)
  {
    switch(true){
      case $exception instanceof MethodNotAllowedHttpException:
       return redirect()->route('home');
    }
    return null;
  }
 
 ```
 ## Добавляем exception NotFoundHttpException
 Создаем директорию в resources views/errors/404.blade.php
 1. Дописываем исключение в функцию handleException
 ```php
  private function handleException($exception, $request)
  {
    switch(true){
      case $exception instanceof MethodNotAllowedHttpException:
        return redirect()->route('home');
      case $e instanceof NotFoundHttpException:
        return redirect()->route('fallback');
    }
    return null;
  }
 ```
 2. Создаем route('fallback');
 ```php
  Route::any('/404', function(){
    return response()->view('error.404', [], 404);
  })->name('fallback');
