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
      $offSet = $this->getOffSet($request->page); //Получаем отступ offset
      $company = $this->getCompany();       //Получаем компанию 
      $directions = $this->getDirections()  //Получаем направления
      $countOfPages = $this->countOfPages() //Получаем количество страниц
      $pageNumber = $this->pageNumber() //получаем номер страницы
      
      return response()->json(
      [
        'directions' => $directions,
      ]);
    }
  }
```

3. В blade file выводим models в таблицу.
```php
            <table class="table">
                //Форма поиска
                <form action="" method="POST">
                    <div class="form-group row">
                        <label for="search" class="col col-form-label">Поиск направления:</label>
                        <div class="col-8">
                        <input type="text" id="search" class="form-control" placeholder="Введите фамилию для поиска">
                        </div>
                    </div>
                </form>
                <thead>
                    <th>Номер<button id="id" class="btn btn-link sort active" value="asc"><i id="sort-number-caret" class="bi bi-caret-up"></i></button>
                    </th>
                    <th >
                        <div class="d-flex">
                        <span>
                            Дата выдачи
                        </span>          
                        <button id="date" class="btn btn-link sort" value="asc"><i id="sort-data-caret" class="bi bi-caret-up"></i></button>                           
                        </div>  
                    </th>
                    <th>Вид направления</th>
                    <th>ФИО
                    <button id="fullname" class="btn btn-link sort" value="asc"><i id="sort-number-caret" class="bi bi-caret-up"></i></button>
                    </th>
                    <th>Должность</th>
                    <th>Действия</th>
                </thead>
                <tbody class="directions">
                  //Выводим направления
                </tbody>
            </table>
            <table class="table">
                <tbody class="pagination">
                //Выводим пагинацию
                </tbody>
            </table>
```
