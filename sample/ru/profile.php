<?php
require_once "database.php";
try
{
	$password0 = hash("sha512", trim($_POST["password0"]));
	$password1 = hash("sha512", trim($_POST["password1"]));
	$password2 = hash("sha512", trim($_POST["password2"]));
	$sth = $dbh->prepare(
		"select password from account where account_id = ?");
	$sth->execute([$account_id]);
	$password = $sth->fetchColumn();
	if($password != $password0)
	{
		http_response_code(403);
		header($CT_TEXT);
		exit("Неверный старый пароль");
	}
	if($password1 != $password2)
	{
		http_response_code(400);
		header($CT_TEXT);
		exit("Новые пароли не совпадают");
	}	
	$sth = $dbh->prepare(
		"update account set password = ? where account_id = ?");
	$sth->execute([$password1, $account_id]);
	header($CT_TEXT);
	exit("login.html?logout=on");
}
catch(Exception $ex)
{
	http_response_code(500);
	header($CT_TEXT);
	exit($ex->getMessage());
}
