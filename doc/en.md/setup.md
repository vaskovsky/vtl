# Configuring VTL Applications

## Contents

* [Installing VTL Application](#installing-vtl-application)
* [Configuring connection to SQLite](#configuring-connection-to-sqlite)
* [Configuring connection to PostgreSQL](#configuring-connection-to-postgresql)
* [Configuring connection to MySQL](#configuring-connection-to-mysql)
* [Change administrator password](#change-administrator-password)
* [Scalability](#scalability)

## Installing VTL Application

To install the VTL application:
1. Specify settings in the configuration file `config.php`.
2. Upload program files to a web server.

## Configuring connection to SQLite

By default, the program creates a database file `univer.sqlite3`
in the home directory of the user, under which PHP is run.

If you're happy with that, then no settings need to be spelled out,
delete file `config.php`, if you have previously created it.

If the default settings don't work,
create a file `config.php` in the program directory, containing text:

```
<?php
$DB_DSN = 'sqlite:/path/to/univer.sqlite3';
```
where

`/path/to/univer.sqlite3`: absolute path to the database file `*.sqlite3`.

Make sure, that user, under which PHP is run,
has write permissions to this file.

## Configuring connection to PostgreSQL

Create an empty database on the PostgreSQL server.

Create a file `config.php` in the program directory, containing text:

```
<?php
$DB_DSN = 'pgsql:host=localhost;dbname=univer';
$DB_USER = 'postgres';
$DB_PASS = 'postgres_password';
```
where

`localhost`: server name, where the database is located;

`univer`: database name;

`postgres`: PostgreSQL username;

`postgres_password`: PostgreSQL user password.

## Configuring connection to MySQL

Create an empty database on the MySQL server.

Create a file `config.php` in the program directory, containing text:

```
<?php
$DB_DSN = 'mysql:host=localhost;dbname=univer;charset=UTF8';
$DB_USER = 'mysql_user';
$DB_PASS = 'mysql_password';
```
where

`localhost`: server name, where the database is located;

`univer`: database name;

`mysql_user`: MySQL username;

`mysql_password`: MySQL user password.

## Change administrator password

Default,
* Administrator Login: `admin`
* Administrator Password: `admin`

To change the default values, add to the file `config.php` text:

```
$ADMIN_LOGIN = "new_admin_login";
$ADMIN_PASSWORD = "new_admin_password";
```
where

`new_admin_login`: new default administrator login.

`new_admin_password`: new default administrator password.

After the database is initiated,
administrator login and password can be changed only through the web interface.
Login and password in the file `config.php` will be ignored.

Be sure to change the administrator password after installing the application.

To do this, select the menu item [Settings](sample/en/profile.html).

## Scalability

The web application has two parts: front-end and backend,
which can be located on different servers.

The backend server hosts PHP files,
which deliver data for the web application.

One or more front-end servers can access a single backend server.

The front-end server hosts static HTML files and script `api.js`.
This allows
* change the design of the application without knowledge of JavaScript, PHP and other technologies,
* cache front-end on client,
* use CDN to load the frontend faster from anywhere in the world.

Default, front-end looks for backend on the same server, in the same directory,
but you can specify a different location by using the element

```
<link id="server" href="http://vaskovsky.net/vtl/sample/en/" rel="preconnect"/>
```
________________________________________________________________________________
[↩ VTL](index.md)
<style>pre {white-space: pre-wrap}</style>
