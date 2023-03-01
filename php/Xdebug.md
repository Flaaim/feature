# XDEBUG HOMESTEAD VSCODE
https://tighten.com/insights/debugging-configure-xdebug-and-laravel-homestead-and-vs-code-and-phpunit/

https://github.com/xdebug/vscode-php-debug/issues/220#issuecomment-373961242
## Дополнительные настройки

Добавить открытие ссылок из браузера в vsc: `xdebug.file_link_format="vscode://file/%f:%l" `

```
//launch.json
        {
            "name": "Listen for XDebug on Homestead",
            "type": "php",
            "request": "launch",
            "pathMappings": {
                "/home/vagrant/code/parce": "${workspaceFolder}"
            },
            "port": 9003,
        },
  ```
