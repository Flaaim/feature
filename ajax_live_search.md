# Ajax live search

1. Создаем функцию в контроллере, например showDirections(Request $request). Функция возвращает json ответ.
```php
  public function showDirections(Request $request)
  {
    if($request->ajax()){
        $models = Model::all(); //получаем модель
        if($request->keyword){
          $models = Model::where('name', 'LIKE', '%'.$request->keyword.'%')->get();
        }
        
        return response()->json([
          'models' => $models
        ]);
    }
  }
```
