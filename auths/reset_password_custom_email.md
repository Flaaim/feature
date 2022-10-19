# Custom Email for reset password

1. Модель User наследуется от класса Illuminate\Foundation\Auth\User as Authenticatable, который использует trait Illuminate\Auth\Passwords\CanResetPassword.
2. В модели User переопределяем метод sendPasswordResetNotification из traita CanResetPassword. 
```php
//Model User
  use App\Notifications\CustomResetPasswordNotification;
  public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

```
3. В методе используем созданное уведомление. 
```php
php artisan make: notification CustomResetPasswordNotification
```
4. Описываем созданный файл CustomResetPasswordNotification.php. 
4.1. Переопределям конструктор
4.2. Переопределяем метод toMail($notifiable)
4.3. Переопределяем метод buildMailMessage($url)
```php
use Illuminate\Auth\Notifications\ResetPassword;

class CustomResetPasswordNotification extends ResetPassword
{
    public function __construct($token)
    {
        parent::__construct($token);
        
    }
    
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return $this->buildMailMessage($this->resetUrl($notifiable));
    }
    
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Восстановление пароля')
            ->line('Вы получили данное сообщение потому что запросили восстановление пароля в личный кабинет.')
            ->action('Восстановить пароль', $url)
            ->line('Ссылка на восстановление пароля истечет через :count минут.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')])
            ->line('Если вы не запрашивали восстановление пароля. Никаких действий не требуется');
    }
}
```
## Customize mail template
1. Копируем шаблоны уведомлений в папку resources. Меняем шаблон под себя.
```php
  php artisan vednor:publish --tag=laravel-notifications
```


