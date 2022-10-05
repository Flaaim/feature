## Создаем Personal Access Token

Заходим через postman, регистрируем bearer token.

1. Создаем в api.php маршруты для получения всех записей и добавления записи
```php
  Route::get('tweets', [App\Http\Controllers\TweetController::class, 'index'])->middleware('auth:api'); //получение всех записей 
  Route::post('tweets', [App\Http\Controllers\TweetController::class, 'store'])->middleware('auth:api'); //добавление записи.
```
