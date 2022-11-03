# Установка Homestead
1. Клонируем репозиторий.
```
git clone https://github.com/laravel/homestead.git ~/Homestead
```
2. Устанавливаем Homestead. https://app.vagrantup.com/laravel/boxes/homestead.
3. Меняем имя у скаченного файла на homestead.box
4. Добавляем box в vagrant
```
  vagrant box add laravel/homestead [полный путь к скачанному файлу].
```
5. Апдейтим box. Переходим в c:/users/[пользователь]/.vagrant.d/boxes/laravel-VAGRANTSLASH-homestead В данной папке создаем файл metadata_url. В данном файле прописываем следующую ссылку.
```
https://app.vagrantup.com/laravel/boxes/homestead 
```
6. Далее переименовываем папку с названием 0 на 12.1.0, где 12.1.0 это версия laravel/homestead бокса
