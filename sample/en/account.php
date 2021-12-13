<?php
require_once 'database.php';
try
{
	if($role_id < 3)
	{
		http_response_code(401);
		header($CT_TEXT);
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
		if(empty($_POST))
		{
			$sth = array($account);
		}
		else
		{
			$params = array();
			$login = (string) trim($account['login']);
			if(isset($_POST['login']))
				$login = (string) trim($_POST['login']);
			$params[] = $login;
			$password = hash('sha512', trim($account['password']));
			if(!empty($_POST['password']))
				$password = hash('sha512', trim($_POST['password']));
			$params[] = $password;
			$role_id = (int) trim($account['role_id']);
			if(isset($_POST['role_id']))
				$role_id = (int) trim($_POST['role_id']);
			$params[] = $role_id;
			$sth = $dbh->prepare("insert into account(login, password, role_id) values (?, ?, ?)");
			$sth->execute($params);		
		}
	}
	else if(isset($_GET['account_id']))
	{
		$keys = array();
		$account_id = (int) trim($_GET['account_id']);
		$keys[] = $account_id;
		$sth = $dbh->prepare("select account.account_id, account.login, account.password, display_role_id.role_name, account.role_id from account inner join role display_role_id on display_role_id.role_id = account.role_id where account.account_id = ?");
		$sth->execute($keys);
		if(!empty($_POST))
		{
			$account = $sth->fetch();
			if(!$account)
			{
				http_response_code(404);
				header($CT_TEXT);
				exit("Not found");
			}
			$params = array();
			$login = $account["login"];
			if(isset($_POST['login']))
				$login = (string) trim($_POST['login']);
			$params[] = $login;
			$password = $account["password"];
			if(!empty($_POST['password']))
				$password = hash('sha512', trim($_POST['password']));
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
	else if(isset($_GET["login"]))
	{
		$login = (string) trim($_GET['login']);
		$sth = $dbh->prepare("select account.account_id, account.login, account.password, display_role_id.role_name, account.role_id from account inner join role display_role_id on display_role_id.role_id = account.role_id where account.login = ?");
		$sth->execute([$login]);
	}
	else
	{
		$sth = $dbh->query("select account.account_id, account.login, display_role_id.role_name, account.role_id from account inner join role display_role_id on display_role_id.role_id = account.role_id");
	}
	if(empty($_POST))
	{
		$select_role_id = $dbh->query("select role_id, role_name from role order by role_name");
		header($CT_XML);
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
		header($CT_TEXT);
		exit("account.html");
	}	
}
catch(Exception $ex)
{
	http_response_code(500);
	header($CT_TEXT);
	exit($ex->getMessage());
}
