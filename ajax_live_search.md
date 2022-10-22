# Ajax live search

1. Создаем функцию в контроллере, например search(Request $request). Функция возвращает json ответ.
```php
  public function search(Request $request)
  {
    if($request->ajax()){
        $models = Model::all(); //получаем модель
        if($request->keyword != ''){
          $models = Model::where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        }
        
        return response()->json([
          'models' => $models
        ]);
    }
  }
```

2. Прописываем маршруты
```php
  Route::post('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
```

3. Добавляем форму поиска в шаблон
```php
  <form action="" method="POST">
  
  </form>
```
5. Пишем ajax запрос
```javascript
  <script>
    
  </script>
  ```
