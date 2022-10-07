## Создаем Personal Access Token

Заходим через postman, регистрируем bearer token.

1. Создаем в api.php маршруты для получения всех записей и добавления записи
```php
  Route::get('tweets', [App\Http\Controllers\TweetController::class, 'index'])->middleware('auth:api'); //получение всех записей 
  Route::post('tweets', [App\Http\Controllers\TweetController::class, 'store'])->middleware('auth:api'); //добавление записи.
```
## Создаем новое приложение Fresher
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
```
6. В первом приложении создаем OAUTH Client. Name Fresher, Redirect http://fresher/callback.
7. В приложении fresher web.php прописываем новые маршруты
```php
  Route::group(['middleware' => 'auth'], function(){
    Route::get('/auth/twitter', [App\Http\Controllers\TwitterAuthController::class, 'redirect']);
    Route::get('/callback', [App\Http\Contollers\TwitterAuthController::class, 'callback']);
  });
```
8. Создаем TwitterAuthController. Прописываем в нем методы redirect(), callback()
```php
//TwitterAuthController

  public function redirect(Request $request){
    $request->session()->put('state', $state = Str::random(40));
    $query = http_build_query([
      'client_id' => 5, //свое значение
      'redirect_uri' => 'http://fresher/callback',
      'response_type' => 'code',
      'scope' => '',
      'state' => $state
    ]);
    return redirect('http://fresh/oauth/authorize?'.$query);
    }
   public function callback(Request $request){
    $state = $request->session()->pull('state');
    throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );
        $response = Http::asForm()->post('http://fresh/oauth/token', [
                'grant_type' => 'authorization_code',
                'client_id' => 5,
                'client_secret' => 'WhIaLxWfvYkhnfKoBjdHUiNcmDUhE0A5foTFEMAM',
                'redirect_uri' => 'http://fresher/callback',
                'code' => $request->code,
        ]);
        $response = $response->json();
        
        
        $request->user()->token()->delete();
        $request->user()->token()->create([
            'access_token' => $response['access_token'],
        ]);
        return redirect()->route('home');
   }
```
