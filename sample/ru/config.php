<?php
################################################################################
## 1. Настройки
################################################################################
### 1.1. База данных
$DATA_ROOT = dirname($_SERVER["DOCUMENT_ROOT"]).DIRECTORY_SEPARATOR;
$DB_DSN = "sqlite:{$DATA_ROOT}sample.sqlite3";
$DB_USER = null;
$DB_PASSWORD = null;
### 1.2. Администратор
$ADMIN_LOGIN = "admin";
$ADMIN_PASSWORD = "admin";
### 1.3. Соль для шифрования паролей
$SALT = "5e8ff9bf55ba3508199d22e984129be6";
################################################################################
## 2. Инициализация
################################################################################
### 2.1. Отключить отображения ошибок PHP
ini_set("display_errors", "0");
### 2.2. Зашифровать пароль администратора
$ADMIN_PASSWORD = hash("sha512", "$ADMIN_PASSWORD$SALT");
### 2.3. Подключиться к базе данных
$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
	[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
### 2.4. Забыть данные для подключения к БД
unset($DB_DSN);
unset($DB_USER);
unset($DB_PASSWORD);
### 2.5. Получить данные сессии
session_start();
$account_id = (int) @$_SESSION["account_id"];
$role_id = (int) @$_SESSION["role_id"];
################################################################################
