<?php
require_once "config.php";
try
{
	$password0 = hash("sha512", trim($_POST["password0"]).$SALT);
	$password1 = hash("sha512", trim($_POST["password1"]).$SALT);
	$password2 = hash("sha512", trim($_POST["password2"]).$SALT);
	$sth = $dbh->prepare(
		"select password from account where account_id = ?");
	$sth->execute([$account_id]);
	$password = $sth->fetchColumn();
	if($password != $password0)
	{
		http_response_code(403);
		header("Content-Type: text/plain;charset=UTF-8");
		exit("Неверный старый пароль");
	}
	if($password1 != $password2)
	{
		http_response_code(400);
		header("Content-Type: text/plain;charset=UTF-8");
		exit("Новые пароли не совпадают");
	}	
	$sth = $dbh->prepare(
		"update account set password = ? where account_id = ?");
	$sth->execute([$password1, $account_id]);
	header("Content-Type: text/plain;charset=UTF-8");
	exit("login.html?logout=on");
}
catch(Exception $ex)
{
	http_response_code(500);
	header("Content-Type: text/plain;charset=UTF-8");
	exit($ex->getMessage());
}
