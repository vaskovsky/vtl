# Масштабируемость

Веб-приложение состоит из двух частей: фронтенд и бэкенд,
которые могут располагаться на разных серверах.

На бэкенд-сервере размещаются файлы PHP,
которые поставляют данные для веб-приложения.

К одному бэкенд-серверу могут обращаться один или несколько фронтенд-серверов.

На фронтенд-сервере размещаются статичные файлы HTML и скрипт `api.js`.
Это позволяет
* изменять дизайн приложения без знания JavaScript, PHP и других технологий,
* кэшировать фронтенд на стороне клиента,
* использовать CDN для более быстрой загрузки фронтенда из любой точки мира.

По умолчанию, фронтенд ищет бэкенд на том же сервере, в той же директории,
но можно указать другое расположение с помощью элемента

```
<link id="server" href="https://vaskovsky.ru/vtl/sample/ru/" rel="preconnect"/>
```
________________________________________________________________________________
