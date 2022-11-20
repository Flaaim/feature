# Создание хлебных крошек

1. Устанавливаем пакет composer
```
 composer require diglactic/laravel-breadcrumbs
```
2. В папке routes создаем файл breadcrumbs.php
3. В данном файле определяем маршруты для хлебных крошек
```php
Use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Register', route('register'));
});
```
4. Вывод хлебных крошек в файле layouts.app.blade.php
```
{!! Breadcrumbs::render() !!}
//чтобы на главной не вывадились используем
//app
@section('breadcrumbs', Breadcrumbs::render())
@yield('breadcrumbs')
//home
@section('breadcrumps', '')
```
