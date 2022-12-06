# User status update after verify email
## method #1
1. Создаем listener `MarkUserActive`.
``` 
php artisan make:listener MarkUserActive --event=Illuminate\Auth\Events\Verified
```
2. Обновляем User status в методе `handle`
```
class MarkUserActive
{
    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $event->user->update('status' => true);
    }
}
```
3. В EventServiceProvider `shouldDiscoverEvents()` устанавливаем значение `true` //автоматическое добавление listener'ov
4. Или регистриуем listener вручную
```
//EventServiceProvider
    protected $listen = [
        Verified::class => [
            MarkUserActive::class,
        ]
    ];
 ```
 
