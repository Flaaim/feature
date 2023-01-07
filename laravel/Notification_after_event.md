- url: https://www.coditty.com/code/how-to-make-event-listener-and-notification-in-laravel
- пример в: https://github.com/Flaaim/feedback

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
3. Определяем событие.
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
4. Создаем уведомление, которое будет отправляться пользователям при отработке события: php artisan make:notification ApplicationCreateNotification. В ApplicationCreateNotification в методе construct() определяем данные которые будет передаваться в сообщение.
```php
//ApplicationCreateNotification

  private $data;
  
  public function __construct()
  {
    $this->data = $data;
  }
```
5. Определяем содержание письма, при необходимости передаем данные и т.д.
6. Определяем listener. В методе handle() определяем кому или кто будет получать уведомления, например:
```php
    public function handle(ApplicationCreate $event)
    {
        $users = User::whereHas('role', function($query){
            $query->where('title', 'Manager');
        })->get();
        foreach($users as $user){
            $user->notify(new ApplicationCreateNotification($event->application));
        }
        
    }

```
7. Добавляем event, где он должен быть вызван.
```php
event(new ApplicationCreate($model));
```
