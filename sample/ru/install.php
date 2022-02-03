<?php
header("Content-Type: text/plain;charset=UTF-8");
echo "* Установка программы...\n";
ini_set("display_errors", "1");
ini_set("html_errors", false);
error_reporting(E_ALL);
try
{
	if(file_exists("config.php")) require "config.php";
	else exit("Файл не найден `config.php`");
	ini_set("display_errors", "1");
	$DB_DRIVER = $dbh->getAttribute(PDO::ATTR_DRIVER_NAME);
	if("sqlite" == $DB_DRIVER)
	{
		$dbh->exec("CREATE TABLE IF NOT EXISTS role(role_id INTEGER NOT NULL PRIMARY KEY, role_name TEXT NOT NULL)");
		$dbh->exec("INSERT OR IGNORE INTO role(role_id, role_name) VALUES (1, 'Пользователь')");
		$dbh->exec("INSERT OR IGNORE INTO role(role_id, role_name) VALUES (2, 'Модератор')");
		$dbh->exec("INSERT OR IGNORE INTO role(role_id, role_name) VALUES (3, 'Администратор')");
		$dbh->exec("CREATE TABLE IF NOT EXISTS account(account_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, login TEXT NOT NULL, password TEXT NOT NULL, role_id INTEGER NOT NULL, FOREIGN KEY (role_id) REFERENCES role(role_id) ON UPDATE CASCADE ON DELETE CASCADE)");
		$dbh->exec("CREATE INDEX IF NOT EXISTS account_by_login ON account(login)");
		$dbh->exec("INSERT OR IGNORE INTO account(account_id, login, password, role_id) VALUES (1, '$ADMIN_LOGIN', '$ADMIN_PASSWORD', 3)");
	}
	else if("pgsql" == $DB_DRIVER)
	{
		$dbh->exec("CREATE TABLE IF NOT EXISTS role(role_id INTEGER NOT NULL PRIMARY KEY, role_name TEXT NOT NULL)");
		$dbh->exec("INSERT INTO role(role_id, role_name) VALUES (1, 'Пользователь') ON CONFLICT DO NOTHING");
		$dbh->exec("INSERT INTO role(role_id, role_name) VALUES (2, 'Модератор') ON CONFLICT DO NOTHING");
		$dbh->exec("INSERT INTO role(role_id, role_name) VALUES (3, 'Администратор') ON CONFLICT DO NOTHING");
		$dbh->exec("CREATE TABLE IF NOT EXISTS account(account_id SERIAL NOT NULL PRIMARY KEY, login TEXT NOT NULL, password TEXT NOT NULL, role_id INTEGER NOT NULL, FOREIGN KEY (role_id) REFERENCES role(role_id) ON UPDATE CASCADE ON DELETE CASCADE)");
		$dbh->exec("CREATE INDEX IF NOT EXISTS account_by_login ON account(login)");
		$dbh->exec("INSERT INTO account(account_id, login, password, role_id) VALUES (1, '$ADMIN_LOGIN', '$ADMIN_PASSWORD', 3) ON CONFLICT DO NOTHING");
		$dbh->exec("SELECT setval('account_account_id_seq', 2, true)");
	}
	else if("mysql" == $DB_DRIVER)
	{
		$dbh->exec("CREATE TABLE IF NOT EXISTS role(role_id INTEGER NOT NULL PRIMARY KEY, role_name TEXT NOT NULL)");
		$dbh->exec("INSERT IGNORE role(role_id, role_name) VALUES (1, 'Пользователь')");
		$dbh->exec("INSERT IGNORE role(role_id, role_name) VALUES (2, 'Модератор')");
		$dbh->exec("INSERT IGNORE role(role_id, role_name) VALUES (3, 'Администратор')");
		$dbh->exec("CREATE TABLE IF NOT EXISTS account(account_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, login TEXT NOT NULL, password TEXT NOT NULL, role_id INTEGER NOT NULL, INDEX (login), FOREIGN KEY (role_id) REFERENCES role(role_id) ON UPDATE CASCADE ON DELETE CASCADE)");
		$dbh->exec("INSERT IGNORE account(account_id, login, password, role_id) VALUES (1, '$ADMIN_LOGIN', '$ADMIN_PASSWORD', 3)");
	}
	else exit("СУБД не поддерживается: $DB_DRIVER");
	echo "* Установка завершена.";
}
catch(PDOException $ex)
{
	exit($ex->getMessage());
}
