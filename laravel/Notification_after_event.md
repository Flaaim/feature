# Отправка уведомлений после события.
1. Регистрируем event and listener.
```php
App\Providers\EventServiceProvider

protected $listen = [
  ApplicationCreate::class => [
    SendApplicationNotification::class,
  ],
];
```
2. Выполняем команду php artisan event:generate. Данная команда создаст event и listener.
3. Определяем событие
```php
//ApplicationCreate
use App\Models\Application;

class ApplicationCreate
{
...
public $application;

public function __construct()
{
  $this->application = $application;
}
...
}
```
