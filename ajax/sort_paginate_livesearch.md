# Живой поиск, сортировка столбцов, пагинация Laravel
1. Прописываем route, который будет осуществлять все действия.
```php
//web.php
  route::post('/search', [App\Controllers\NameOfController::class, 'showResults'])->name('showResults');
```
2. Создаем контроллер NameOfController. Метод для обрабоки запросов showResult();
```php
  //NameOfController
  public function showResults(Request $request)
  {
    if($request->ajax())
    {
      
    
    }
  }
```
