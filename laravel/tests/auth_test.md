## Тестирование модуля Auth
url: https://medium.com/@DCzajkowski/testing-laravel-authentication-flow-573ea0a96318
1. что user может получить доступ/открыть страницу с логином
2. что user не может увидеть/открыть страницу с логином, если он уже аутентифицирован.
3. что user может успешно залогиниться, используя свои данные для входа.
4. что user получает remember-me cookie если ставить галочку на чекбоксе remember me
5. что user не может залогиниться с несуществующим email'ом
6. что user не может залогиниться с неправильным паролем
7. что user может разлогиниться, если он аутентифицирован

```php
class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A test what user can view login form
     *
     * @return void
     */
    public function test_what_user_can_view_login_form()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Авторизация');
    }

    /**
     * A test what user cannot view login form if authenticated
     * 
     * @return void
     */

    public function test_what_user_cannot_view_login_form_if_authenticated()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }

    public function test_what_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
        
    }

    public function test_what_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create();
        $response = $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'incorrect_password']);

        $response->assertRedirect('/login');
        $this->assertGuest();

    }

    public function test_what_user_can_get_remember_me_cookie()
    {
        $user = User::factory()->create();
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password', 'remember' => 'on']);

        $response->assertRedirect('/home');

        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s',
        [
            $user->id,
            $user->getRememberToken(),
            $user->password
        ]));
        $this->assertAuthenticatedAs($user);
    }

    public function test_what_user_cannot_login_with_incorrect_email()
    {
        $user = User::factory()->create();
        $response = $this->from('/login')->post('/login', ['email' => 'Wrong@mail.com', 'password' => 'password']);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_what_user_can_logout_after_authenticated()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
```
