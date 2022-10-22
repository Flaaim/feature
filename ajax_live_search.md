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
    <input type="text" id="search">
  </form>
```
5. Пишем ajax запрос
```javascript
  <script>
         $.ajaxSetup({
         headers: 
         {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         $('#search').on('keyup', function(){
            search();
         });
         search();
         function search(){
          let keyword = $('#search').val();
          $.ajax({
            url: "{{route('search')}}",
            method: "POST",
            data: {keyword:keyword},
            dataType: "json",
            success: function(data){
              table_post_row(data)
            }, error(data){
            console.log('error!')
            }
          });
         }
         
         function table_post_row(res){
         let htmlView = "";
                 if(res.models.length <= 0){
                  htmlView += `
                  <tr>
                    <td >ничего не найдено!</td>
                    </tr>`;
                  }
                   for(let i = 0; i < res.directions.length; i++){
                  console.log(res.models[i]);
                  htmlView += `
                  <tr>
                    <td>`+ res.directions[i].number +`</td>
                    <td>`+ res.directions[i].date +`</td>
                    <td>`+ res.directions[i].typeOfDirection +`</td>
                    <td>`+ res.directions[i].fullname +`</td>
                    <td>`+ res.directions[i].profession +`</td>
                </tr>`;
        }
          $('.tablename').html(htmlView); // .tablename - сss свойство класс таблицы, куда вставляются данные
         }
    });
  </script>
  ```
