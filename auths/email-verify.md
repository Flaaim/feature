# Email веритификация laravel

1.  В модели User добавляем
```php
use lluminate\Contracts\Auth\MustVerifyEmail;
model User extends Authenticatable implements MustVerifyEmail
{

}

```

2. Добавляем в web.php 
```php
    Auth::routes(['verify' => true]);
```

3. Прописываем доступ к почтовому серверу
```php
    //Google gmail 

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=Flaeim@gmail.com
    MAIL_PASSWORD=rbkpxhqyeqboxvqp
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="MedCheckUp@gmail.com"
```
4. В Homecontroller добавляем middleware 'verified'