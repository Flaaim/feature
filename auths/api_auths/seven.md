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
