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
