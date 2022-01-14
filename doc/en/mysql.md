# Configuring connection to MySQL

Create an empty database on the MySQL server.

Open the file `config.php`.

Find the lines:

```
### 1.1. Database
$DATA_ROOT = dirname($_SERVER["DOCUMENT_ROOT"]).DIRECTORY_SEPARATOR;
$DB_DSN = "sqlite:{$DATA_ROOT}sample.sqlite3";
$DB_USER = null;
$DB_PASSWORD = null;
```

Replace the parameter values `$DB_DSN`, `$DB_USER`, `$DB_PASSWORD`:

```
$DB_DSN = 'mysql:host=localhost;dbname=sample;charset=UTF8';
$DB_USER = 'mysql_user';
$DB_PASSWORD = 'mysql_password';
```
where

`localhost`: MySQL server name;

`sample`: database name;

`mysql_user`: MySQL username;

`mysql_password`: MySQL user password.
________________________________________________________________________________
[↩ Back](javascript:history.back();)
