<?php
################################################################################
## 1. Settings
################################################################################
### 1.1. Database
$DATA_ROOT = dirname($_SERVER["DOCUMENT_ROOT"]).DIRECTORY_SEPARATOR;
$DB_DSN = "sqlite:{$DATA_ROOT}sample.sqlite3";
$DB_USER = null;
$DB_PASSWORD = null;
### 1.2. Administrator
$ADMIN_LOGIN = "admin";
$ADMIN_PASSWORD = "admin";
### 1.3. Password encryption salt
$SALT = "5e8ff9bf55ba3508199d22e984129be6";
################################################################################
## 2. Initialization
################################################################################
### 2.1. Disable PHP error displaying
ini_set("display_errors", "0");
### 2.2. Encrypt administrator password
$ADMIN_PASSWORD = hash("sha512", "$ADMIN_PASSWORD$SALT");
### 2.3. Connect to database
$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD,
	[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
### 2.4. Forget data to connect to the database
unset($DB_DSN);
unset($DB_USER);
unset($DB_PASSWORD);
### 2.5. Get session data
session_start();
$account_id = (int) @$_SESSION["account_id"];
$role_id = (int) @$_SESSION["role_id"];
################################################################################
