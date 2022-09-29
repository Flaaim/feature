# Auth with google
1. Устанавливаем socialite. // composer require laravel/socialite
2. В config/app.php добавляем providers и aliases
```php
'providers' => [
  Laravel\Socialite\SocialiteServiceProvider::class,
  ...
  ],
  
  'aliases' => [
  //...
  'Socialite' => Laravel\Socialite\Facades\Socialite::class,
  ]
```
3. В config/services.php добавляем 
```php
  'google' => [
    'client_id'     => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect'      => env('GOOGLE_REDIRECT')
],
```
4. Создаем акк в google. Создаем credentials, добавляем redirect_url
5. Добавляем данные в env файл. (credentials and redirect)
```php
GOOGLE_CLIENT_ID=788046726236-db9p2hmv0qik1qa8q6spq60mf19d1e2t.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT=http://localhost/auths/google/callback
```
6. Прописываем routes
```php
    Route::get('/google', [LoginController::class, 'redirectToGoogle'])->name('auths.google');
    Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auths.googleCallback');
```
7. Прописываем методы в LoginController
```php
public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('auths.login');
        }
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            Auth::login($existingUser);
            return redirect()->to($this->redirectTo);
        }else {
            //Register User
        }
  ```
  8. Добавляем в таблицу users столбец google_id
