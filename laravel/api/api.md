# Api
*Содержание*

- [Простая Api](#простая-api)
- [Api sanctum](#api-sanctum)

## Простая Api
https://daily-dev-tips.com/posts/laravel-basic-api-routes/

1. Routes необходимо прописывать в routes/api.php
```php
Route::resource('announcements', App\Http\Controllers\AnnouncementController::class);
```

2. Создаем Контроллер, Модель и Ресурс. `php artisan make:controller AnnouncementController --resource --model=Announcement`, `php artisan make:resource Announcement`
```php
//AnnouncementController
public function index()
{
        $announcements = Announcement::paginate();
        return AnnouncementResource::collection($announcements);
}
public function store(Request $request)
{
        
        $validated = $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);
        $announcement = Announcement::create($validated);
        return new AnnouncementResource($announcement);
}
public function show(Announcement $announcement)
{
        return new AnnouncementResource($announcement);
}
public function update(Request $request, Announcement $announcement)
{
        $validated = $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);
        $announcement->update($validated);
        return new AnnouncementResource($announcement);
}
public function destroy(Announcement $announcement)
{
        $announcement->delete();
        return response(null, Response::HTTP_NO_CONTENT);
}
//добавить use Symfony\Component\HttpFoundation\Response;
```
4. В Postman необходимо в headers необходимо прописать `Accept: application/json`

## Api sanctum
https://daily-dev-tips.com/posts/protecting-our-laravel-api-with-sanctum/
1. Устанавливаем sanctum `php artisan composer require laravel/sanctum` 
2. Конфиг `php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider" `
3. Добавляем middleware `app/Http/Kernel.php`
```php
'api' => [
	\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
	'throttle:api',
	\Illuminate\Routing\Middleware\SubstituteBindings::class,
],
4. Создаем пользователя, с помощью seed или просто вручную.
5. Создаем контроллер AuthController и метод login.
```php
//AuthController
public function login(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid login details'
        ], 401);
    }

    $user = User::where('email', $request['email'])->firstOrFail();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}
```
6. Создаем route в `routes/api.php`
```php
        Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
```
7. Защищаем routes.
```php
Route::group(['middleware'=> 'auth:sanctum'], function() {
    ...
});
```
