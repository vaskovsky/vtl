# Configuring connection to PostgreSQL

Create an empty database on the PostgreSQL server.

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
$DB_DSN = 'pgsql:host=localhost;dbname=sample';
$DB_USER = 'postgres';
$DB_PASSWORD = 'postgres_password';
```
where

`localhost`: PostgreSQL server name;

`sample`: database name;

`postgres`: PostgreSQL username;

`postgres_password`: PostgreSQL user password.
________________________________________________________________________________
[↩ Back](javascript:history.back();)
