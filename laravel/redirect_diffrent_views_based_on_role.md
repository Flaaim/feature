# Редирект на view в зависимости от роли
https://medium.com/fabcoding/laravel-redirect-users-according-to-roles-and-protect-routes-bde324fe1823

1. Создаем контроллеры UserController, ManagerController. Создаем в контроллерах методы, которые будут обрабатывать обращения
```php
//UserController
  public function index()
  {
    return view('user.index');
  }
  
  //ManagerController
  public function index()
  {
    return view('manager.index');
  }
```php
2. Создаем маршруты 
```
  Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [App\Http\Controllers\ManagerController::class, 'index']);
    Route::get('/feedback', [App\Http\Controllers\UserController::class, 'index']);
  });
 3. Переопределяем метод redirectPath() в LoginController. 
 ```php
    return (Auth::user()->role == 'Manager') ? '/dashboard' : '/feedback';
 ```
 4. Изменяем метод handle в RedirectIfAuthenticated middleware.
 ```php
  return (Auth::user()->role == 'Manager') ? '/dashboard' : '/feedback';
 ```
 5. Создаем middleware Role. Регистрируем middleware в Kernel
 ```php
 //$routeMiddleware
  'role' => \App\Http\Middleware\Role::class
 ```
 ```php
     public function handle(Request $request, Closure $next, $role)
    {
        if($request->user()->role->title == $role){
            return $next($request);
        }
        return back();
    }
 ```
 6. Добавляем в маршруты middleware
```php
    Route::get('/feedback', [App\Http\Controllers\UserController::class, 'index'])->name('user')->middleware('role:User');
    Route::get('/dashboard', [App\Http\Controllers\ManagerController::class, 'index'])->name('manager')->middleware('role:Manager');
```
