# Роли и привелегии.
## 1. Подготовка 
- Таблицы в BD:
```
|users, roles, permissions,|
|role_user, permission_role| 
```
- Создаем миграции:
```
//permissions('id', 'alias', 'title'),
//role_user('id', 'role_id', 'user_id'),
//permission_role('id', 'permission_id', 'role_id'),
```
- Создаем модели: Role, Permission
- Создаем контролеры: RoleController, PermissionController
- Создаем Policy: RolePolicy
## 2. Модели.
2. Описываем связи моделей. Связи будут многие ко многим. 
```
//Roles
//Не забываем добавить $fillable
public function perms(){
	return $this->belongsToMany(Permission::class);
}

public function users(){
	return $this->belongsToMany(User::class);
}
```
2.1 Добавляем в модель Role вспомогательный метод, который будет синхранизировать или отвязывать permissions от roles.
```
//Role
public function savePermissions($perms) {
	if(!empty($perms)){
		$this->roles->sync($perms);
	} else {
		$this->roles->detach();
	}
}

```
## 3. Policy

3.1 Регистрируем созданную политику RolePolicy в AuthServiceProvider. В RolePolicy создаем необходимые методы (view, create, edit, update и т.д.)
```
//RolePolicy
public function view(){
return true; //временно устанавливаем такую заглушку.
}
public function create(){
return true; //временно устанавливаем такую заглушку.
}
```
## 4. Контроллеры
4.1. RoleController. Создаем для него CRUD операции. (index, create, store, edit, update, delete);
4.2. В перечесляемых методах добавляем 
```
$this->authorize('view', Role::class);
```
4.3. Routes. Определяем routes для контроллеров.

5. Blade
5.1 Создаем страницу отображения ролей (index). Страница должна содержать: список всех ролей, кнопку создать новую роль, редактирование, удаление ролей.
5.2. Создаем страницу связывания ролей и привелегий. Контроллер - PermissionController, метод - 'index'
```
	Permissions |	Admin |  Moderator |  User |
	Full_access |   []    |   []       |   []  |
	View_roles  |   []    |   []       |   []  |
```
Верхняя шапка создается обходом циклом ролей (foreach $roles as $role). 
Тело таблицы создается с помощью вложенного цикла. 
```
//<tbody>
	foreach($perms as $val)
		<tr>
		  <td>
		    {{$val->title}}
		  </td>
			@foreach ($roles as $role)
                        <td>
                            @if ($role->hasPermission($val->alias))//временно метод закоментировать
                                <input type="checkbox" value="{{$val->id}}" name="{{$role->id}}[]" checked>
                            @else
                                <input type="checkbox" value="{{$val->id}}" name="{{$role->id}}[]">
                            @endif 
                        </td>
                        @endforeach	
		</tr>
```
6. Сохранение ролей и привелегий в базе данных.
```
//Форма передает массив в виде:
	[
	'1' => ['0' => '1' , '1' => '2'],
	'2' => ['0' => '1'], 
	]
//metod store PermissionController, который обрабатывает это запрос.

	public function store(Request $request) {
		$data = $request->except('_token');

		$roles = Role::all();
		foreach($roles as $role) {
			if(isset(data[$role->id])){
				$role->savePermission($data[$role->id]);		
			} else {
				$role->savePermission([]);
			}
		}
	}
```
7. Сохранение отмеченных чекбоксов. Для сохранения чекбоксов используется метод hasPermission модели Role.
```
//Role

public function hasPermission($alias) {
	foreach($this->perms as $perms) {
		if($perms->alias == $alias) {
		return true;
	}
	}
return false;
}

8. Трэйт RoleUsers. Создаем trait RoleUsers.php. Подключаем данный trait к модели User.
```php
	public function canDo($alias) {
	if(is_array($alias)){
	  foreach($alias as $permAlias){
        return $this->canDo($permAlias);
      }
	} else {
    foreach($this->roles as $role) {
      foreach($role->perm as $perm) {
        if($perm->alias == $alias){
          return true;
        }
      }
    }
  }
	return false;
	} 
```
