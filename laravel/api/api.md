# Простая Api'шка
https://daily-dev-tips.com/posts/laravel-basic-api-routes/

1. Routes необходимо прописывать в routes/api.php
```php
Route::resource('announcements', App\Http\Controllers\AnnouncementController::class);
```

2. Создаем Контроллер, Модель и Ресурс. `php artisan make:controller AnnouncementController --resource --model=Announcement`, `php artisan make:resource Announcement`
```php
//AnnouncementController
public function index()
{
        $announcements = Announcement::paginate();
        return AnnouncementResource::collection($announcements);
}
public function store(Request $request)
{
        
        $validated = $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);
        $announcement = Announcement::create($validated);
        return new AnnouncementResource($announcement);
}
public function show(Announcement $announcement)
{
        return new AnnouncementResource($announcement);
}
public function update(Request $request, Announcement $announcement)
{
        $validated = $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);
        $announcement->update($validated);
        return new AnnouncementResource($announcement);
}
public function destroy(Announcement $announcement)
{
        $announcement->delete();
        return response(null, Response::HTTP_NO_CONTENT);
}
//добавить use Symfony\Component\HttpFoundation\Response;
```
4. В Postman необходимо в headers необходимо прописать `Accept: application/json`
