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
      $company = $this->getCompany($this->user);       //Получаем компанию 
      $directions = $this->getDirections($request, $company, $offSet)  //Получаем направления
      $countOfPages = $this->countOfPages($company) //Получаем количество страниц
      $pageNumber = $this->pageNumber() //получаем номер страницы
      
      return response()->json(
      [
        'directions' => $directions, //возвращает направления
        'countofpages'=> $countOfPages, //возвращает количество страниц
        'pagenumber' => $pageNumber, //возвращает номер страницы
      ]);
    }
  }
  
  public function getOffSet($page)
  {
    return ($page != 1) ? ($page * 5) - 5 : 0 // Например страница 2 -> (2*5) - 5 = 5, 3 -> 10 и т.д.
  }
  public function $company($user)
  {
    //Получаем компанию выбранного пользователя и активную status = 1
    return Company::where('status', '1')->where('user_id', $user->id)->first();
  }
  
  public function getDirections($request, $company, $offSet)
  {
    //Если форма поиска не используется, то выводиться все направления выбранной компании + сортировка и разбивка offset по 5 записей
    return ($request->keyword == '') ? 
        DB::table('directions')
            ->where('company_id', $company->id)
                ->orderBy($request->field, $request->sort)
                        ->offset($offSet)->limit(5)->get() : 
        DB::table('directions')->where('company_id', $company->id)
                ->where('fullname', 'LIKE', '%'.$request->keyword.'%')->get();
        
  }
  
  public function getCountpages($company)
  {
    //Количество страниц с направлениями = округлить в большую стророну(кол-во направлений / 5)
    $directions = DB::table('directions')->where('company_id', $company->id)->get();
    return ceil(count($directions) / 5);
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
