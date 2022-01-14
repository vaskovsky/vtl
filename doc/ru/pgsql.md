# Настройка соединения с PostgreSQL

Создайте пустую базу данных на сервере PostgreSQL.

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
$DB_DSN = 'pgsql:host=localhost;dbname=sample';
$DB_USER = 'postgres';
$DB_PASSWORD = 'postgres_password';
```
где

`localhost`: имя сервера PostgreSQL;

`sample`: имя базы данных;

`postgres`: имя пользователя PostgreSQL;

`postgres_password`: пароль пользователя PostgreSQL.
________________________________________________________________________________
[↩ Назад](javascript:history.back();)
