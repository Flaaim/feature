# Docker 
## 1. Базовые команды 
```
  docker images - список образов в системе,
  docker ps - список всех запущенных контейнеров + -a // список контейнеров, которые запускали
  docker rm <id> - удаление контейнера
  docker run -d -P --name <image> // -d detached mode, -P открыть порты, --name название будущего контейнера
  docker port <контейнер> - увидеть порты. 
```

## Создание проекта Laravel
1. В рабочей директории проекта ларавель cоздаем файл docker-compose.yml
2. Создаем образ mysql
```yml
  version "3"
  
  services:
    mysql:
      image: mysql
      environment:
        MYSQL_ROOT_PASSWORD: secret
        MYSQL_USER: app
        MYSQL_PASSWORD: secret
        MYSQL_DATABASE: app    
```


