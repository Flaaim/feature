## Раздел Developers
1. Создаем контроллер php artisan make:controller DeveloperController. 
2. В созданном контроллере прописываем метод index и __construct()
```php

  public function __construct(){
    $this->middleware('auth');
  }
  
  public function index(){
    return view('developers.index');
  }
```
3. Создаем view: resources\views\developer\index.blade.php
4. Описываем index.blade.php
```php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
           
                <div class="card-header">
                    <div class="card-body">
                    <passport-clients></passport-clients>
                </div>

                <div class="card-header">
                    <div class="card-body">
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endsection
```
6. Прописываем routes
```php
  Route::get('/developers', [App\Http\Controllers\DeveloperController::class, 'index']);
```
7. Копируем vue компоненты AuthorizedClients, Clients, PersonalAccessTokens в resources\js\components\passport\
8. Регистрируем компоненты в app.js.
