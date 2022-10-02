## Часть 2
1. Создаем файл PostTweet.vue, добавляем компонент в app.js
```vue
  import PostTweetComponent from './components/PostTweet.vue';
  app.component('post-tweet', PostTweetComponent);
```
2. В файле Timeline.vue добавляем 
```
<script>
import PostTweet from './PostTweet.vue'
...

components: [
   PostTweet
],
```
3. Добавляем в Timeline.vue <post-tweet></post-tweet>
4. Файл PostTweet.vue 
```
  <template>
    <form action="#" @submit.prevent="post">
        <div class="form-group">
            <textarea class="form-control" cols="30" rows="2" v-model="body"></textarea>
            <button class="btn btn-primary" type="submit">Post</button>
        </div>
    </form>
</template>

<script>
    export default {
        data(){
            return {
                body: null
            }
        },
        props: [
            'tweets'
        ],
        methods: {
            post(){
                axios.post('/tweets', {body: this.body})
                .then((response) => {
                    this.tweets.unshift(response.data)
                    this.data = null
                });
            }
        }
    }
</script>
```
5. TweetController 
```php
  public function store(Request $request){
    $this->validate($request, ['body' => 'required']);
    $tweet = $request->user()->tweets()->create(['body' => $request->body])->load('user');
    return $tweet;
  }

```
6. Добавляем Route
```php

// web.php
  Route::post('/tweets', [App\Http\Controllers\TweetController::class, 'store']);
```
7. Добавляем в Timeline.vue <post-tweet :tweets="tweets"></post-tweet>
