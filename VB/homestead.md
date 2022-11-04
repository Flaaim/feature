# Установка Homestead
1. Клонируем репозиторий.
```
git clone -b realise https://github.com/laravel/homestead.git ~/Homestead
```
3. Иницируем
```
bash init.sh
 
# Windows...
init.bat
```
5. Устанавливаем Homestead. https://app.vagrantup.com/laravel/boxes/homestead.
6. Меняем имя у скаченного файла на homestead.box
7. Добавляем box в vagrant
```
  vagrant box add laravel/homestead [полный путь к скачанному файлу].
```
5. Апдейтим box. Переходим в c:/users/[пользователь]/.vagrant.d/boxes/laravel-VAGRANTSLASH-homestead В данной папке создаем файл metadata_url. В данном файле прописываем следующую ссылку.
```
https://app.vagrantup.com/laravel/boxes/homestead 
```
6. Далее переименовываем папку с названием 0 на 12.1.0, где 12.1.0 это версия laravel/homestead бокса
7. выполняем vagrant up
8. Синхронизируем folders. 
```
folders:
    - map: C:\Users\flaaim\Code
      to: /home/vagrant/code
```
9. Прописываем в файле hosts C:\Windows\System32\drivers\etc\hosts
```
  192.168.56.56  homestead.test
```
