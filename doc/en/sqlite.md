# Configuring connection to SQLite

By default, the program creates a database file in the directory
`$DATA_ROOT = dirname($_SERVER["DOCUMENT_ROOT"])`.

If you're happy with that, then no settings need to be spelled out.

If the default settings don't work, open the file `config.php`.

Find the lines:

```
### 1.1. Database
$DATA_ROOT = dirname($_SERVER["DOCUMENT_ROOT"]).DIRECTORY_SEPARATOR;
$DB_DSN = "sqlite:{$DATA_ROOT}sample.sqlite3";
```
	
Replace the value of `$DB_DSN`:

```
$DB_DSN = 'sqlite:/path/to/sample.sqlite3';
```
where

`/path/to/sample.sqlite3`: absolute path to the database file `*.sqlite3`.

Make sure, that user, under which PHP is run,
has write permissions to this file.
________________________________________________________________________________
[↩ Back](javascript:history.back();)
