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

git log --pretty=oneline в одну линию.
