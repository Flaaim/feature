# Git основные команды в работе
## Содержание

1. [Основы](#основы)
2. [Детатчед](#детатчед)
3. [Перемещение изменений](#перемещение-изменений)
4. [Удаленные репозитории](#удаленные-репозитории)

## Основы
1. Создание новой ветки: `git branch newImage`
2. Смена ветки: `git checkout [name]`, `git switch [name]`
3. Создание новой ветки и переключение на нее: `git checkout -b [name]`, `git switch -c [name]`
4. Слияние двух веток: `git merge [branch]`
5.  Rebasing: `git rebase [branch]`

Подсказка по ребазингу №1: Находясь на ветке bugFix накладываем изменения поверх main `git rebase main`, переключаемся на ветку main `git switch main`, и выполняем `git rebase bugFix`

Подсказка по ребазингу №2: `git rebase main bugFix` //накладывает изменения поверх main с ветки bugFix. 

## Детатчед
1. detaching HEAD: `git checkout [commit]`
2. Перемещение на один коммит назад: `git checkout HEAD^`
3. Перемещение на несколько коммитов назад: `git checkout HEAD~<num>` //Вместо HEAD можно указывать ветку, например `main^` или `main~2`
4. Перемещение если несколько родителей: `git checkout HEAD^2` //цифра обозначает родителя на которого необходимо перейти. 
5. Прикрепление ветки к коммиту: `git branch -f main HEAD~3` //Переместит (принудительно) ветку main на три родителя назад от HEAD
6. Отмена (local): `git reset` //отменяет изменения, перенося ссылку на ветку назад, на более старый коммит `git reset HEAD~1`
7. Отмена (remote): `git revert` //`git revert HEAD` создаст новый коммит с изменениями полностью противоположными последнему коммиту 

## Перемещение изменений
1. Копирование нескольких коммитов: `git cherry-pick <Commit1> <Commit2> <...>` //Копирование одного или нескольких коммитов на место, где сейчас находиться HEAD.
2. Интерактивный rebase: `git rebase -i HEAD~4` // Копирует 4 последних коммита
3. Теги: `git tag v1 [hash]`
4. Посмотреть расстояние до тега: `git describe  <ref>`

## Операции отмены

git commit --amend 		 	переделать последний коммит.

git restore -- staged <file> 		отменить индекс файла (отмена git add <file>)

git checkout -- <file> 			отмена сделанных изменений в файле (до git add <file>)
  
Убрать файл из коммита: remove files from commit
git restore --source=HEAD^ --staged  -- <file>

## Удаленные репозитории

git remote 				просмотр удаленных настроенных репозиториев

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
