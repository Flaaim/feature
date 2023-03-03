# Git основные команды.
## Содержание

1. [Основы](#основы)
2. [Детатчед](#детатчед)
3. [Перемещение изменений](#перемещение-изменений)


## Основы
1. Создание новой ветки: `git branch newImage`
2. Смена ветки: `git checkout [name]`, `git switch [name]`
3. Создание новой ветки и переключение на нее: `git checkout -b [name]`, `git switch -c [name]`
4. Слияние двух веток: `git merge [branch]`
5.  Rebasing: `git rebase [branch]`

Подсказка по ребазингу: Находясь на ветке bugFix накладываем изменения поверх main `git rebase main`, переключаемся на ветку main `git switch main`, и выполняем `git rebase bugFix`

## Детатчед
1. detaching HEAD: `git checkout [commit]`
2. Перемещение на один коммит назад: `git checkout HEAD^`
3. Перемещение на несколько коммитов назад: `git checkout HEAD~<num>` //Вместо HEAD можно указывать ветку, например `main^` или `main~2`
4. Прикрепление ветки к коммиту: `git branch -f main HEAD~3` //Переместит (принудительно) ветку main на три родителя назад от HEAD
5. Отмена (local): `git reset` //отменяет изменения, перенося ссылку на ветку назад, на более старый коммит `git reset HEAD~1`
6. Отмена (remote): `git revert` //`git revert HEAD` создаст новый коммит с изменениями полностью противоположными последнему коммиту 

## Перемещение изменений
1. Копирование нескольких коммитов: `git cherry-pick <Commit1> <Commit2> <...>`


## Операции отмены

git commit --amend 		 	переделать последний коммит.

git restore -- staged <file> 		отменить индекс файла (отмена git add <file>)

git checkout -- <file> 			отмена сделанных изменений в файле (до git add <file>)
  
Убрать файл из коммита: remove files from commit
git restore --source=HEAD^ --staged  -- <file>

## Удаленные репозитории

git remote 				просмотр удаленный настроенных репозиториев

git remote add <shortname> <url> 	добавление удаленных репозиториев

git fetch [remote name]			получение изменений из удаленного репозитория [забирает все данные проекта которые нет]
  
  
## Добавление изменений в коммит

git commit --amend
  
## Rebase
  //on some branch
git rebase main
git swithc main
git merge somebranch

## Просмотр изменений
  
git diff path/to/file просмотр изменений в конкретном файле

git diff --staged path/to/file просмотр изменений к конкретном файле, после добавления файла в индекс командой git add
  
## Logging

git log --pretty=oneline отобразить коммиты в одну линию.
  
## Clone

git clone <url> <folder name> клонирование в новый/сущесвующий репозиторий
  
## .Ignore
В директории root создаем файл .gitignore, в котором прописываем директории, которые необходимо игнорировать
```
  /vendor
```
