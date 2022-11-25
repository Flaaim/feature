## Scopes
1.  В приложении fresh в AuthServiceProvider в функции boot() прописываем Passport:tokensCan();
```php

  //AuthServiceProvider

  use Laravel\Passport\Passport;
  
  Passport:tokensCan([
      'veiw-tweets' => 'View Tweets',
      'post-tweets' => 'Post Tweets',
    ]);
 ```
 2. В методе контроллера, который описывает route '/redirect' добавляем scope 
 ```php
  'scope' => 'view-tweets post-tweets'
 ```
 3. В приложении fresh в app/Http/Kernel.php добавляем в $routeMiddleware
```php
   'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
    'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
```
4. В приложении fresh в api.php добавляем middleware к route::post
```php
Route::post('/tweets', [App\Http\Controllers\TweetController::class, 'store'])->middleware(['auth:api', 'scope:post-tweets']);
```
## Устанавливаем срок жизни токена и обновление токена
1. В приложении fresh создаем миграцию php artisan make:migration add_refresh_and_expires_in_tokens_table --table=tokens
```php
  $table->text('refresh_token');
  $table->bigInteger('expires_in');
  
  //if you need to drop table columns 
  $table->dropColumn(['refresh_token', 'expires_in']);
```
2. Обновляем метод callback в TwitterAuthController
```
  $request()->user()->tokens()->create([
    'access_token' => $response['access_token'],
    'refresh_token' => $response['refresh_token'],
    'expires_in' => $response['expires_in'],
  ]);
```
3. При необходимости можно установить срок жизни токена. В AuthServiceProvider метод boot()
```
Passport::tokensExpireIn(now()->addDays(15));
```
