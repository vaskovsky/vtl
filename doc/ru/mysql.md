# Настройка соединения с MySQL

Создайте пустую базу данных на сервере MySQL.

Откройте файл `config.php`.

Найдите строки:

```
### 1.1. База данных
$DATA_ROOT = dirname($_SERVER["DOCUMENT_ROOT"]).DIRECTORY_SEPARATOR;
$DB_DSN = "sqlite:{$DATA_ROOT}sample.sqlite3";
$DB_USER = null;
$DB_PASSWORD = null;
```

Замените значение параметров `$DB_DSN`, `$DB_USER`, `$DB_PASSWORD`:

```
$DB_DSN = 'mysql:host=localhost;dbname=sample;charset=UTF8';
$DB_USER = 'mysql_user';
$DB_PASSWORD = 'mysql_password';
```
где

`localhost`: имя сервера MySQL;

`sample`: имя базы данных;

`mysql_user`: имя пользователя MySQL;

`mysql_password`: пароль пользователя MySQL.
________________________________________________________________________________
[↩ Назад](javascript:history.back();)
