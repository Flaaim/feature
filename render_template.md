# Render template
```php
use Auth;

class Base extends Controller 
{
  protected $template;
  protected $vars;
  protected $user;
  
  public function __construct()
  {
    $this->template = 'main';
    
    $this->middleware(function($request, $next){
      $this->user = Auth::user();
      return $next($request);
    });
  }
  
  protected renderOutput()
  {
    $this->vars = Arr::add($this->vars, 'content', $this->content);
    
    return view($this->template)->with($this->vars);
  }

}
```

```php

class HomeController extends BaseController 
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function index()
  {
    $this->content = view('dashboard')->render();
     return $this->renderOutput();
  }
}
```

```php
  //layouts.app
  
  //main.blade.php
  @extends('layouts.app')
  
  @section('content')
      {!! $content !!}
  @endsection
  
// dashboard.blade

  ...
```
