# Мультиязычность
## Базы данных
1. Создаем таблицу в базе данных с языками. table languages.

| id | title | code | base |
|----|-------|------|------|
|primary key, ai | varchar(255) | varchar(4) | tinyint, default(1)|

## Создаем widget Language
1. Создаем папку widgets/Language/, внутри создаем Language.php, lang_tpl.php.
2. В Language создаем следующие свойства класса: 
```php
class Language {
  protected $lang_tpl; //содержить путь к файлу /widgets/Language/lang_tpl.php
  protected $laguages; //Содержит все доступные языки из БД
  protected $language; //Содержит текущий язык.
  }
```
3. Создаем функции:
```php
class Language {
  ...
  public function __construct()
  {
    $this->lang_tpl = //определяем путь до файла lang_tpl.php, например project/app/widgets/Language/lang_tpl.php
    $this->run(); //функция запускает виджет.
  }
  public function getLanguages()
  {
    //выполняем sql запрос к БД, чтобы получить все доступные языки. Запрос должен быть ORDER by base DESC, чтобы массив с base 1 всегда был на первом месте.
    Массив полученных данных должнен быть следующим:
    [
      'ru' => [
        'id' => '1',
        'title' => 'Русский',
        'code' => 'ru',
        'base' => '1'
        ],
      'en' => [
        'id' => '2',
        'title' => 'English',
        'code' => 'en',
        'base' => '0'
        ]
	    ];
      while($row = $stmt->fetch()){
        $data[$row['code']] = $row;
      }
   
  } 
  public function getLanguages($languages) 
  {
    $lang = \Wfm\App::$app->getProperty('lang'); // получаем lang из контейнера App 
    if($lang && array_key_exists($lang, $languages)){ //Проверяем сущ $lang и наличие такого ключа в массиве $languages
      $key = $lang; //присваиваем переменной $key значение $lang 
    }elseif(!$lang){ 
      $key = key($languages) //присваиваем переменной $key значение по 1-му ключу в массиве.
    }else{
      throw new \Exception("Language $lang not found");
    }
    $lang_info = $languages[$key];
    return $lang_info
  }
  public function run()
  {
    $this->languages = \Wfm\App::$app->getProperty('languages');
    $this->language = \Wfm\App::$app->getProperty('language');
    echo $this->getHtml(); //отвечает за вызов виджета.
  }
  protected getHtml()
  {
    ob_start();
    require_once $this->lang_tpl;
    ob_get_clean();
  }
```
4. В AppController записываем все доступные языки из БД и текущий язык в контейнер App.
```php
class AppController extends Controller
{
	public function __construct()
	{
	...
	\Wfm\App::$app->setProperty('languages', \App\widgets\Language\Language::getLanguages());
	\Wfm\App::$app->setProperty('language',  \App\widgets\Language\Language::getLanguage(\App\widgets\Language\Language::getLanguages()));
	}
}
5. В routes добавляем маршрут с lang
```php
	//routes.php
	Router::add('^(?P<lang>[a-z]+)?/?$', ['controller'=>'Main', 'action' => 'index']);
```
6. В Router.php, необходимо проверить наличие в routes lang, 
```php
	if(!empty(self::$route['lang'])){
		App::$app->setProperty('lang', self::$route['lang']);
	}
```

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  - function getLanguage($laguages); //Получаем текущий язык на основе достпных из БД.
  - function run(); 
