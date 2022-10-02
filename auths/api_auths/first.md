## Auth Api Часть 1

1. Создаем проект composer require laravel/laravel fresh
2. Определяем имя базы данных в файле .env DB_DATEBASE = fresh
3. Устанавливаем UI: composer require laravel/ui, php artisan ui bootstrap -auth, npm install, npm run dev, php artisan ui vue
4. Запускаем миграции php artisan migrate
5. В config/app.php прописываем 'name' => 'Twitter', В app.blade.php меняем nav bar '/home'
6. Создаем миграцию php artisan make:migration create_tweets_table --create=tweets
```php
  $table->bigInteger('user_id')->unsigned()->index();
  $table->text('body');
  
  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

```
7. Создаем model Tweet. Прописываем связи
```php
  //Model Tweet
  protected $fillable = ['body']
  
  public function user(){
    return $this->belongsTo(User::class);
  }
  
  //Model User
  
  public function tweets(){
    return $this->hasMany(Tweet:class);
  }
```


9. Создаем фабрику. php artisan make:factory TweetFactory
```php
 return = [
  'body' => fake()->sentence
 ]
```
10. php artisan tinker, далее заполняем данные
```php
\App\Models\Tweet::factory(10)->create(['user_id' => 1]);
```
11. Создаем контроллер php artisan make:controller TweetController, прописываем метод и routes
```php
  //web.php
  Route::group(['middleware' => 'auth'], function(){
    Route::get('/tweets', [App\Http\Controllers\TweetController::class, 'index']);
  });
  //TweetController
  public function index(Request $request) {
    return $request->user()->tweets()->with('user')->get();
  }
```
12. Переходим в home.blade.php удаляем всё из секции @cоntent. Переходим в resourses/js/components/ переименовываем в Timeline.vue. 
13. В resourses/js/app.js
```php
  import ExampleComponent from './components/Timeline.vue';
  app.component('Timeline', ExampleComponent);
```
14. В home.blade.php в @section вставляем <timeline></timeline>
15.  Выполняем команду npm build ???
16. В Timeline.vue
```php
export default {
        data(){
            return {
                tweets: []
            }
        },
        mounted() {
            axios
            .get('/tweets')
            .then(response => (this.tweets = response.data))
        }
    }
    
    
    
                        <div class="card-header">Timeline</div>

                    <div class="card-body" >
                        <div class="media" v-for="tweet in tweets">
                            <img src="https://eu.ui-avatars.com/api/?size=64" class="img-responsive" alt="avatar">
                            <div class="media-body">
                                    {{tweet.user.name}}
                                <p>
                                    {{tweet.body}}
                                </p>
                            </div>
                        </div>
                    </div>
```
