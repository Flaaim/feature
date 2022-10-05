## Создаем Personal Access Token

Заходим через postman, регистрируем bearer token.

1. Создаем в api.php маршруты для получения всех записей и добавления записи
```php
  Route::get('tweets', [App\Http\Controllers\TweetController::class, 'index'])->middleware('auth:api'); //получение всех записей 
  Route::post('tweets', [App\Http\Controllers\TweetController::class, 'store'])->middleware('auth:api'); //добавление записи.
```
## Добавляем новое приложение
1. Создаем еще одно приложение composer create-project laravel/laravel fresher. 
2. Создаем скафолдинг auth. composer require ui, php artisan ui bootstrap --auth
3. запускаем стандартные миграции
4. Создаем миграцию php artisan make:migration create_tokens_table --create=tokens
```php
  $table->bigInteger('user_id')->unsigned()->index();
  $table->text('access_token');
  
  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
  ```
  5. Создаем model Token. В модели прописываем связи и свойсво $fillable
  ```php
  
    //Token model
    
    protected $fillable = [
      'access_token',
    ];
    
    public function user(){
      return $this->hasOne(User::class)
    }
    
    //User model
    
    public function token() {
      return $this->belongsTo(Token::class);
    }
