<?php
require_once 'config.php';
if($role_id < 3)
{
	http_response_code(401);
	header("Content-Type: text/plain;charset=UTF-8");
	exit("login.html");
}
if(isset($_GET["new"]))
{
	$account = array(
		"account_id" => "",
		"login" => "",
		"password" => "",
		"role_name" => "",
		"role_id" => "1",
	);
	$params = array();
	$login = (string) trim($account['login']);
	if(isset($_POST['login']))
		$login = (string) trim($_POST['login']);
	$account['login'] = $login;
	$params[] = $login;
	$password = hash('sha512', trim($account['password']).$SALT);
	if(!empty($_POST['password']))
		$password = hash('sha512', trim($_POST['password']).$SALT);
	$account['password'] = $password;
	$params[] = $password;
	$role_id = (int) trim($account['role_id']);
	if(isset($_POST['role_id']))
		$role_id = (int) trim($_POST['role_id']);
	$account['role_id'] = $role_id;
	$params[] = $role_id;
	if(empty($_POST))
	{
		$sth = array($account);
	}
	else if(!isset($_POST["delete"]))
	{
		$sth = $dbh->prepare("INSERT INTO account(login, password, role_id) VALUES (?, ?, ?)");
		$sth->execute($params);		
	}
}
else if(isset($_GET['account_id']))
{
	$keys = array();
	$account_id = (int) trim($_GET['account_id']);
	$keys[] = $account_id;
	$sth = $dbh->prepare("SELECT account.account_id, account.login, account.password, display_role_id.role_name, account.role_id FROM account INNER JOIN role display_role_id ON display_role_id.role_id = account.role_id WHERE account.account_id = ?");
	$sth->execute($keys);
	if(!empty($_POST))
	{
		$account = $sth->fetch();
		if(!$account)
		{
			http_response_code(404);
			header("Content-Type: text/plain;charset=UTF-8");
			exit("Not found");
		}
		if(isset($_POST["delete"]))
		{
			$sth = $dbh->prepare("DELETE FROM account WHERE  account.account_id = ?");
			$sth->execute($keys);
		}
		else
		{
			$params = array();
			$login = $account["login"];
			if(isset($_POST['login']))
				$login = (string) trim($_POST['login']);
			$params[] = $login;
			$password = $account["password"];
			if(!empty($_POST['password']))
				$password = hash('sha512', trim($_POST['password']).$SALT);
			$params[] = $password;
			$role_id = $account["role_id"];
			if(isset($_POST['role_id']))
				$role_id = (int) trim($_POST['role_id']);
			$params[] = $role_id;
			foreach($keys as $key) $params[] = $key;
			$sth = $dbh->prepare("update account set login = ?,  password = ?,  role_id = ? where  account.account_id = ?");
			$sth->execute($params);
		}
	}
}
else if(isset($_GET["login"]))
{
	$login = (string) trim($_GET['login']);
	$sth = $dbh->prepare("SELECT account.account_id, account.login, account.password, display_role_id.role_name, account.role_id FROM account INNER JOIN role display_role_id ON display_role_id.role_id = account.role_id WHERE account.login = ?");
	$sth->execute([$login]);
}
else
{
	$sth = $dbh->query("SELECT account.account_id, account.login, display_role_id.role_name, account.role_id FROM account INNER JOIN role display_role_id ON display_role_id.role_id = account.role_id");
}
if(empty($_POST))
{
	$select_role_id = $dbh->query("SELECT role_id, role_name FROM role ORDER BY role_name");
	header("Content-Type: application/xml;charset=UTF-8");
	echo '<account_data>';
	$counter = 0;
	foreach($sth as $account)
	{
		echo	'<account'.
				' account_id="'.htmlspecialchars($account['account_id'], ENT_COMPAT | ENT_XML1).'"'.
				' login="'.htmlspecialchars($account['login'], ENT_COMPAT | ENT_XML1).'"'.
				' role_name="'.htmlspecialchars($account['role_name'], ENT_COMPAT | ENT_XML1).'"'.
				' role_id="'.htmlspecialchars($account['role_id'], ENT_COMPAT | ENT_XML1).'"'.
				'/>';
		$last_role_id = $account['role_id'];
		$counter++;
	}
	if(1 == $counter)
	{
		echo '<datalist id="select_role_id">';
		foreach($select_role_id as $row)
		{
			$value = $row['role_id'];
			echo	'<option value="'.
					htmlspecialchars($value, ENT_COMPAT | ENT_XML1).
					'"';
			if($last_role_id == $value)
				echo	' selected="selected"';
			echo	'>'.
					htmlspecialchars($row['role_name'],
						ENT_COMPAT | ENT_XML1).
					'</option>';
		}
		echo '</datalist>';
	}
	exit('</account_data>');
}
else
{
	header("Content-Type: text/plain;charset=UTF-8");
	exit("account.html");
}
