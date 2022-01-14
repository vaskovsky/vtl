<?php
require_once "config.php";
try
{
	if(isset($_GET["logout"]))
	{
		$_SESSION["account_id"] = null;
		$_SESSION["role_id"] = 0;
	}
	if(empty($_POST))
	{
		http_response_code(204);
		exit;
	}
	$return = trim(@$_GET["return"]);
	$login = trim($_POST["login"]);
	$password = hash("sha512", trim($_POST["password"]).$SALT);
	$sth = $dbh->prepare(
		"select * from account where login = ? and password = ?");
	$sth->execute([$login, $password]);
	$account = $sth->fetch();
	if($account)
	{
		$_SESSION["account_id"] = $account["account_id"];
		$_SESSION["role_id"] = $account["role_id"];
		if(empty($return))
		{	
			switch($account["role_id"])
			{
				case 3: $return = "account.html"; break;
				case 2: $return = "index.html#moderator"; break;
				default: $return = "index.html#user";			
			}
		}
		header("Content-Type: text/plain;charset=UTF-8");
		exit($return);
	}
	else
	{
		$_SESSION["account_id"] = null;
		$_SESSION["role_id"] = 0;
		http_response_code(403);
		header("Content-Type: text/plain;charset=UTF-8");
		exit("Неверный логин или пароль");
	}
}
catch(Exception $ex)
{
	http_response_code(500);
	header("Content-Type: text/plain;charset=UTF-8");
	exit($ex->getMessage());
}
